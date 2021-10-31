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
  end;

implementation

{$R *.dfm}

uses JSON, Registry, Lizardry.FormMain, Lizardry.Server,
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
  ResponseCode := Server.Get('index.php?action=login');
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '0' then
  begin
    ShowMsg('Ошибка авторизации!');
    Exit;
  end
  else if ResponseCode = '1' then
  begin
    try
      LoadFromDBItems; { TODO: Выполнять в отдельном процессе }
    except
      ShowMsg('Ошибка загрузки DB!');
      Halt;
    end;
    if IsChatMode then
      FormMain.FrameTown.HideChat;
    if IsCharMode then
      FormMain.FrameTown.HideChar;
    FormMain.FrameTown.DoAction('index.php?action=town');
    FormMain.FrameTown.BringToFront;
    //
    if CheckBox1.Checked then
    begin
      Reg := TRegistry.Create;
      try
        Reg.RootKey := HKEY_CURRENT_USER;
        Reg.OpenKey('\SOFTWARE\Lizardry', True);
        Reg.WriteString('UserName', UserName);
        Reg.WriteString('UserPass', UserPass);
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
begin
  if not TServer.IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  if not IsNewClientVersion then
    ShowMsg('Вы используете самую новую версию клиента!');
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
  I, T, G: Integer;
begin
  Result := '';
  JSONArray := TJSONObject.ParseJSONValue(AJSON) as TJSONArray;
  for I := JSONArray.Size - 1 downto 0 do
  begin
    T := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_type'))
      .JsonValue.Value, 0);
    G := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I))
      .Get('event_char_gender')).JsonValue.Value, 0);
    case T of
      0:
        if (G = 0) then
          Result := Result + Format('Герой %s прибыл в Елвинаар!',
            [TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_char_name'))
            .JsonValue.Value]) + #13#10
        else
          Result := Result + Format('Героиня %s прибылa в Елвинаар!',
            [TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_char_name'))
            .JsonValue.Value]) + #13#10;
      1:
        if (G = 0) then
          Result := Result + Format('Герой %s повысил свой уровень до %s!',
            [TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_char_name'))
            .JsonValue.Value, TJSONPair(TJSONObject(JSONArray.Get(I))
            .Get('event_char_level')).JsonValue.Value]) + #13#10
        else
          Result := Result + Format('Героиня %s повысила свой уровень до %s!',
            [TJSONPair(TJSONObject(JSONArray.Get(I)).Get('event_char_name'))
            .JsonValue.Value, TJSONPair(TJSONObject(JSONArray.Get(I))
            .Get('event_char_level')).JsonValue.Value]) + #13#10;
    end;
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
      S := 'Нажмите чтобы проверить и обновить версию клиента.';
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
