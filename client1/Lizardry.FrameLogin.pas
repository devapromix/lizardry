﻿unit Lizardry.FrameLogin;

interface

uses
  Winapi.Windows,
  Winapi.Messages,
  System.SysUtils,
  System.Variants,
  System.Classes,
  Vcl.Graphics,
  Vcl.Controls,
  Vcl.Forms,
  Vcl.Dialogs,
  Vcl.ExtCtrls,
  Vcl.StdCtrls,
  Vcl.Buttons,
  Vcl.Imaging.PNGImage,
  Vcl.ComCtrls;

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
    bbDebug: TSpeedButton;
    procedure bbRegistrationClick(Sender: TObject);
    procedure bbLoginClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
    procedure InfoClick(Sender: TObject);
    procedure bbUpdateClick(Sender: TObject);
    procedure ComboBox1Change(Sender: TObject);
    procedure bbDebugClick(Sender: TObject);
  private
    { Private declarations }
    function IsNewClientVersion: Boolean;
    function GetEventsText(const AJSON: string): string;
  public
    { Public declarations }
    procedure LoadLastEvents;
    procedure LoadFromDBItems;
    procedure LoadFromDBEffects;
    procedure LoadFromDBEnemies(IsRewriteImage: Boolean = False);
  end;

var
  UserSession: string = '';

implementation

{$R *.dfm}

uses
  JSON,
  IOUtils,
  Registry,
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.Frame.Location.Town,
  Lizardry.Game,
  Lizardry.FormMsg,
  Lizardry.FormInfo;

function GetSession(const S: string): string;
begin
  Result := S.TrimRight(['"', '}']);
  Result := Result.Substring(Result.LastIndexOf('"') + 1);
end;

procedure TFrameLogin.bbDebugClick(Sender: TObject);
begin
  FormInfo.PageControl1.ActivePageIndex := 0;
  FormInfo.ShowModal;
end;

procedure TFrameLogin.bbLoginClick(Sender: TObject);
var
  LResponseJSON, LUserName, LUserPass: string;
  LReg: TRegistry;
begin
  LUserName := Trim(LowerCase(edUserName.Text));
  LUserPass := Trim(LowerCase(edUserPass.Text));
  if not TServer.IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  Panel5.Caption := 'Подтверждение авторизации...';
  Application.ProcessMessages;
  LResponseJSON := Server.Get('index.php?action=login');
  if LResponseJSON = '{"login":"error"}' then
  begin
    Panel5.Caption := 'Ошибка!';
    Application.ProcessMessages;
    ShowMsg('Ошибка авторизации!');
    Exit;
  end;
  if LResponseJSON.StartsWith('{"error":"') then
  begin
    FormMain.FrameTown.ParseJSON(LResponseJSON);
    Exit;
  end;
  if LResponseJSON.StartsWith('{"login":"ok","session":"') then
  begin
    UserSession := GetSession(LResponseJSON);
    Panel5.Caption := 'Готово!';
    Application.ProcessMessages;
    Sleep(500);
    Panel5.Caption := 'Проверка ресурсов...';
    Application.ProcessMessages;
    try
      { TODO: Выполнять в отдельном процессе }
      LoadFromDBItems;
      LoadFromDBEnemies;
      LoadFromDBEffects;
    except
      ShowMsg('Ошибка загрузки DB!');
      Halt;
    end;
    Panel5.Caption := 'Выполняется вход...';
    Application.ProcessMessages;
    Sleep(500);
    Panel5.Caption := '';
    if IsCharMode then
      FormMain.FrameTown.HideChar;
    ServerName := Server.Name;
    FormMain.UpdateCaption;
    FormMain.FrameTown.DoAction('index.php?action=town');
    FormMain.FrameTown.BringToFront;
    //
    begin
      LReg := TRegistry.Create;
      try
        LReg.RootKey := HKEY_CURRENT_USER;
        LReg.OpenKey('\SOFTWARE\Lizardry', True);
        if CheckBox1.Checked then
        begin
          LReg.WriteString('UserName', LUserName);
          LReg.WriteString('UserPass', LUserPass);
        end;
        LReg.WriteInteger('Server', ComboBox1.ItemIndex);
      finally
        LReg.Free;
      end;
    end;
    Exit;
  end
  else
  begin
    ShowMsg('Ошибка авторизации!!!');
    Exit;
  end;
end;

procedure TFrameLogin.bbRegistrationClick(Sender: TObject);
begin
  FormMain.FrameLogin.bbRegistration.Enabled := False;
  FormMain.FrameUpdate.bbUpdImagesClick(Sender);
  FormMain.FrameRegistration.Clear;
  FormMain.FrameRegistration.edUserName.SetFocus;
  FormMain.FrameRegistration.BringToFront;
end;

procedure TFrameLogin.bbUpdateClick(Sender: TObject);
var
  LMessage: string;
begin
  LMessage := '';
  if not TServer.IsInternetConnected then
  begin
    LMessage := 'Невозможно подключиться к серверу!';
  end
  else if not IsNewClientVersion then
    LMessage := 'Вы используете самую новую версию клиента!'
  else
    LMessage := 'Вам нужно обновить клиент!';
  FormMain.FrameUpdate.ttInfo.Caption := LMessage;
  FormMain.FrameUpdate.ttUpdate.Caption := '';
  FormMain.FrameUpdate.BringToFront;
end;

procedure TFrameLogin.ComboBox1Change(Sender: TObject);
begin
  Server.Name := LowerCase(Trim(ComboBox1.Text));
  FormMain.UpdateCaption;
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
  LJSONArray: TJSONArray;
  I, LEventType, LEventCharLevel, LEventCharGender: Integer;
  LEventLocation, LEventCharName, LEventString: string;
begin
  // ShowMessage(AJSON);
  Result := '';
  try
    LJSONArray := TJSONObject.ParseJSONValue(AJSON) as TJSONArray;
    for I := 0 to LJSONArray.Count - 1 do
    begin
      LEventType := StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('event_type')).JsonValue.Value, 0);
      LEventCharGender :=
        StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('event_char_gender')).JsonValue.Value, 0);
      LEventCharName := TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('event_char_name')).JsonValue.Value;
      LEventCharLevel :=
        StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('event_char_level')).JsonValue.Value, 1);
      LEventString := TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('event_str'))
        .JsonValue.Value;
      LEventLocation := TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('event_loc')).JsonValue.Value;
      case LEventType of
        0:
          if (LEventCharGender = 0) then
            Result := Result + Format('%s прибыл в Елвинаар!',
              [LEventCharName]) + #13#10
          else
            Result := Result + Format('%s прибылa в Елвинаар!', [LEventCharName]
              ) + #13#10;
        1:
          if (LEventCharGender = 0) then
            Result := Result + Format('%s поднялся на %d уровень!',
              [LEventCharName, LEventCharLevel]) + #13#10
          else
            Result := Result + Format('%s поднялась на %d уровень!',
              [LEventCharName, LEventCharLevel]) + #13#10;
        2:
          Result := Result + Format('%s теперь носит %s!',
            [LEventCharName, LEventString]) + #13#10;
        3:
          if (LEventCharGender = 0) then
            Result := Result + Format('%s погиб в локации %s!',
              [LEventCharName, LEventLocation]) + #13#10
          else
            Result := Result + Format('%s погибла в локации %s!',
              [LEventCharName, LEventLocation]) + #13#10;
        4:
          if (LEventCharGender = 0) then
            Result := Result + Format('%s победил %s в локации %s!',
              [LEventCharName, LEventString, LEventLocation]) + #13#10
          else
            Result := Result + Format('%s плбедила %s в локации %s!',
              [LEventCharName, LEventString, LEventLocation]) + #13#10;
      end;
    end;
  except
  end;
end;

procedure TFrameLogin.InfoClick(Sender: TObject);
var
  LMessage: string;
begin
  case (Sender as TSpeedButton).Tag of
    1:
      LMessage :=
        'Название учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    2:
      LMessage :=
        'Пароль к учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    3:
      LMessage := 'Нажмите для входа в игру.';
    4:
      LMessage :=
        'Нажмите чтобы зарегистрировать новую учетную запись и создать персонажа.';
    5:
      LMessage :=
        'Дополнительные возможности клиента. Проверка актуальной версии клиента.';
  else
    LMessage := 'Текущая игра проходит в мире LIZARDRY. ' +
      'Другие миры используются для тестирования.';
  end;
  ShowMsg(LMessage);
end;

function TFrameLogin.IsNewClientVersion: Boolean;
var
  LServerVersion: string;
  LClientVersion: string;
begin
  Result := False;
  try
    LClientVersion := Trim(CurrentClientVersion.Caption);
    LServerVersion := Trim(Server.Get('index.php?action=version'));
    if LClientVersion < LServerVersion then
    begin
      Result := True;
      ShowMsg('Необходимо обновить клиент!');
    end;
  except
    ShowMsg('Невозможно подключиться к серверу!');
  end;
end;

procedure TFrameLogin.LoadFromDBEffects;
begin
  try
    FormInfo.EffMemo.Text := Trim(Server.Get('index.php?action=effects'));
  except
  end;
end;

procedure TFrameLogin.LoadFromDBEnemies(IsRewriteImage: Boolean = False);
var
  LJSONArray: TJSONArray;
  LFilePath, LFileName: string;
  LFileStream: TFileStream;
  I: Integer;
begin
  LFilePath := TPath.GetHomePath + '\Lizardry\Images\';
  FormInfo.ImagesPath.Caption := LFilePath;
  ForceDirectories(LFilePath);
  FormInfo.ResMemo.Text :=
    Trim(Server.Get('registration/registration.php?action=resources'));
  Panel5.Caption := 'Проверка и загрузка изображений...';
  FormMain.FrameUpdate.ttUpdate.Caption := Panel5.Caption;
  Application.ProcessMessages;
  try
    LJSONArray := TJSONObject.ParseJSONValue(FormInfo.ResMemo.Text)
      as TJSONArray;
    for I := LJSONArray.Count - 1 downto 0 do
    begin
      LFileName :=
        Trim(LowerCase(TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('enemy_image')).JsonValue.Value));
      if (LFileName = '') or (LFileName = 'enemy_') then
        Continue;
      if IsRewriteImage or not FileExists(LFilePath + LFileName + '.jpg') then
      begin
        LFileStream := TFileStream.Create(LFilePath + LFileName + '.jpg',
          fmCreate);
        try
          Panel5.Caption := 'Загрузка изображения: ' + LFileName +
            '.jpg' + '...';
          FormMain.FrameUpdate.ttUpdate.Caption := Panel5.Caption;
          Application.ProcessMessages;
          Server.IdHTTP.Get('http://' + Server.URL + '/images/' + LFileName +
            '.jpg', LFileStream);
        finally
          LFileStream.Free;
          Panel5.Caption := '';
          FormMain.FrameUpdate.ttUpdate.Caption := '';
        end;
      end;
      Sleep(10);
    end;
  except
  end;
  Panel5.Caption := '';
end;

procedure TFrameLogin.LoadFromDBItems;
begin
  try
    FormInfo.ItemMemo.Text := Trim(Server.Get('index.php?action=items'));
  except
  end;
end;

procedure TFrameLogin.LoadLastEvents;
var
  LEventStr: string;
begin
  if not TServer.IsInternetConnected then
  begin
    StaticText1.Caption := 'Невозможно подключиться к серверу!';
    Exit;
  end;
  Server.Name := LowerCase(Trim(ComboBox1.Text));
  LEventStr := Server.Get('index.php?action=events');
  if (LEventStr[1] = '[') then
    StaticText1.Caption := GetEventsText(LEventStr);
end;

end.
