unit Lizardry.FrameLogin;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls, Vcl.Buttons, Vcl.Imaging.pngimage, Vcl.ComCtrls;

type
  TFrameLogin = class(TFrame)
    Panel1: TPanel;
    edUserName: TEdit;
    bbLogin: TBitBtn;
    Label1: TLabel;
    Label2: TLabel;
    bbRegistration: TBitBtn;
    edUserPass: TEdit;
    CheckBox1: TCheckBox;
    Image1: TImage;
    CurrentClientVersion: TLabel;
    Panel2: TPanel;
    Panel3: TPanel;
    Panel4: TPanel;
    SpeedButton3: TSpeedButton;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton5: TSpeedButton;
    bbUpdate: TBitBtn;
    SpeedButton4: TSpeedButton;
    Label3: TLabel;
    Panel5: TPanel;
    StaticText1: TStaticText;
    Panel6: TPanel;
    ComboBox1: TComboBox;
    Label4: TLabel;
    SpeedButton6: TSpeedButton;
    procedure bbRegistrationClick(Sender: TObject);
    procedure bbLoginClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
    procedure InfoClick(Sender: TObject);
    procedure bbUpdateClick(Sender: TObject);
    procedure ComboBox1Change(Sender: TObject);
  private
    { Private declarations }
    function IsNewClientVersion: Boolean;
    function GetEventsText(const AJSON: string): string;
  public
    { Public declarations }
    procedure LoadLastEvents;
    procedure LoadFromDBItems;
    procedure LoadFromDBEnemies(F: Boolean = False);
  end;

implementation

{$R *.dfm}

uses JSON, IOUtils, Registry, Lizardry.FormMain, Lizardry.Server,
  Lizardry.Frame.Location.Town,
  Lizardry.Game, Lizardry.FormMsg, Lizardry.FormInfo;

procedure TFrameLogin.bbLoginClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass: string;
  Reg: TRegistry;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  if not TServer.IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  Panel5.Caption := 'Подтверждение авторизации...';
  Application.ProcessMessages;
  ResponseCode := Server.Get('index.php?action=login');
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '0' then
  begin
    Panel5.Caption := 'Ошибка!';
    Application.ProcessMessages;
    ShowMsg('Ошибка авторизации!');
    Exit;
  end
  else if ResponseCode = '1' then
  begin
    Panel5.Caption := 'Готово!';
    Application.ProcessMessages;
    Sleep(500);
    Panel5.Caption := 'Проверка ресурсов...';
    Application.ProcessMessages;
    try
      { TODO: Выполнять в отдельном процессе }
      LoadFromDBItems;
      LoadFromDBEnemies;
    except
      ShowMsg('Ошибка загрузки DB!');
      Halt;
    end;
    Panel5.Caption := 'Выполняется вход...';
    Application.ProcessMessages;
    Sleep(500);
    Panel5.Caption := '';
    if IsChatMode then
      FormMain.FrameTown.HideChat;
    if IsCharMode then
      FormMain.FrameTown.HideChar;
    FormMain.FrameTown.DoAction('index.php?action=town');
    FormMain.FrameTown.BringToFront;
    //
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_CURRENT_USER;
        Reg.OpenKey('\SOFTWARE\Lizardry', True);
        if CheckBox1.Checked then
        begin
          Reg.WriteString('UserName', UserName);
          Reg.WriteString('UserPass', UserPass);
        end;
        Reg.WriteInteger('Server', ComboBox1.ItemIndex);
      finally
        Reg.Free;
      end;
    end;
  end
  else
  begin
    ShowMsg('Ошибка авторизации!');
    Exit;
  end;
end;

procedure TFrameLogin.bbRegistrationClick(Sender: TObject);
begin
  FormMain.FrameRegistration.Clear;
  FormMain.FrameRegistration.edUserName.SetFocus;
  FormMain.FrameRegistration.BringToFront;
end;

procedure TFrameLogin.bbUpdateClick(Sender: TObject);
var
  S: string;
begin
  S := '';
  if not TServer.IsInternetConnected then
  begin
    S := 'Невозможно подключиться к серверу!';
  end
  else if not IsNewClientVersion then
    S := 'Вы используете самую новую версию клиента!'
  else
    S := 'Вам нужно обновить клиент!';
  FormMain.FrameUpdate.ttInfo.Caption := S;
  FormMain.FrameUpdate.ttUpdate.Caption := '';
  FormMain.FrameUpdate.BringToFront;
end;

procedure TFrameLogin.ComboBox1Change(Sender: TObject);
begin
  Server.Name := LowerCase(Trim(ComboBox1.Text));
  LoadLastEvents;
end;

procedure TFrameLogin.EnterKeyPress(Sender: TObject; var Key: Char);
begin
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['a' .. 'z', 'A' .. 'Z', '0' .. '9', '_']) then
      Key := #0;
  if Key = #13 then
    bbLogin.Click;
end;

function TFrameLogin.GetEventsText(const AJSON: string): string;
var
  JSONArray: TJSONArray;
  I, EvType, EvLevel, EvGender: Integer;
  EvName, EvStr: string;
begin
  Result := '';
  try
    JSONArray := TJSONObject.ParseJSONValue(AJSON) as TJSONArray;
    for I := 0 to JSONArray.Count - 1 do
    begin
      EvType := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I))
        .Get('event_type')).JsonValue.Value, 0);
      EvGender := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I))
        .Get('event_char_gender')).JsonValue.Value, 0);
      EvName := TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_char_name'))
        .JsonValue.Value;
      EvLevel := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I))
        .Get('event_char_level')).JsonValue.Value, 1);
      EvStr := TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_str'))
        .JsonValue.Value;
      case EvType of
        0:
          if (EvGender = 0) then
            Result := Result + Format('%s прибыл в Елвинаар!', [EvName]
              ) + #13#10
          else
            Result := Result + Format('%s прибылa в Елвинаар!', [EvName]
              ) + #13#10;
        1:
          if (EvGender = 0) then
            Result := Result + Format('%s поднялся на %d уровень!',
              [EvName, EvLevel]) + #13#10
          else
            Result := Result + Format('%s поднялась на %d уровень!',
              [EvName, EvLevel]) + #13#10;
        2:
          Result := Result + Format('%s теперь носит %s!', [EvName, EvStr]
            ) + #13#10;
        3:
          if (EvGender = 0) then
            Result := Result + Format('%s погиб в локации %s!',
              [EvName, EvStr]) + #13#10
          else
            Result := Result + Format('%s погибла в локации %s!',
              [EvName, EvStr]) + #13#10;
      end;
    end;
  except
  end;
end;

procedure TFrameLogin.InfoClick(Sender: TObject);
var
  S: string;
begin
  case (Sender as TSpeedButton).Tag of
    1:
      S := 'Название учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    2:
      S := 'Пароль к учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    3:
      S := 'Нажмите для входа в игру.';
    4:
      S := 'Нажмите чтобы зарегистрировать новую учетную запись и создать персонажа.';
    5:
      S := 'Дополнительные возможности клиента. Проверка актуальной версии клиента.';
  else
    S := 'Текущая игра проходит в мире LIZARDRY. ' +
      'Другие миры используются для тестирования.';
  end;
  ShowMsg(S);
end;

function TFrameLogin.IsNewClientVersion: Boolean;
var
  ServerVersion: string;
  ClientVersion: string;
begin
  Result := False;
  try
    ClientVersion := Trim(CurrentClientVersion.Caption);
    ServerVersion := Trim(Server.Get('index.php?action=version'));
    if ClientVersion < ServerVersion then
    begin
      Result := True;
      ShowMsg('Необходимо обновить клиент!');
    end;
  except
    ShowMsg('Невозможно подключиться к серверу!');
  end;
end;

procedure TFrameLogin.LoadFromDBEnemies(F: Boolean = False);
var
  JSONArray: TJSONArray;
  I: Integer;
  ImageName: string;
  FS: TFileStream;
begin
  FormInfo.MobImagesPath.Caption := TPath.GetHomePath + '\Lizardry\Images\';
  ForceDirectories(FormInfo.MobImagesPath.Caption);
  FormInfo.MemoMobImages.Text := Server.GetFromDB('enemies');
  Panel5.Caption := 'Проверка и загрузка изображений...';
  FormMain.FrameUpdate.ttUpdate.Caption := Panel5.Caption;
  Application.ProcessMessages;
  try
    JSONArray := TJSONObject.ParseJSONValue(FormInfo.MemoMobImages.Text)
      as TJSONArray;
    for I := JSONArray.Count - 1 downto 0 do
    begin
      ImageName := LowerCase(TJSONPair(TJSONObject(JSONArray.Get(I))
        .Get('enemy_image')).JsonValue.Value);
      if F or not FileExists(FormInfo.MobImagesPath.Caption + ImageName + '.jpg')
      then
      begin
        FS := TFileStream.Create(FormInfo.MobImagesPath.Caption + '\' +
          ImageName + '.jpg', fmCreate);
        try
          Panel5.Caption := 'Загрузка изображения: ' + ImageName +
            '.jpg' + '...';
          FormMain.FrameUpdate.ttUpdate.Caption := Panel5.Caption;
          Application.ProcessMessages;
          Server.IdHTTP.Get('http://' + Server.URL + '/images/' + ImageName +
            '.jpg', FS);
        finally
          FS.Free;
          Panel5.Caption := '';
          FormMain.FrameUpdate.ttUpdate.Caption := '';
        end;
      end;
    end;
  except
  end;
  Panel5.Caption := '';
end;

procedure TFrameLogin.LoadFromDBItems;
begin
  FormInfo.RichEdit2.Text := Server.GetFromDB('items');
end;

procedure TFrameLogin.LoadLastEvents;
begin
  if not TServer.IsInternetConnected then
  begin
    StaticText1.Caption := 'Невозможно подключиться к серверу!';
    Exit;
  end;
  Server.Name := LowerCase(Trim(ComboBox1.Text));
  StaticText1.Caption := GetEventsText(Server.Get('index.php?action=events'));
end;

end.
