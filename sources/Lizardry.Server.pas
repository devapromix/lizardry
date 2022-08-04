unit Lizardry.Server;

interface

uses IdHTTP;

type
  TServer = class(TObject)
  private
    FIdHTTP: TIdHTTP;
    FName: string;
    FURL: string;
  public
    function Get(AURL: string): string;
    function GetFromDB(const S: string): string;
    constructor Create(const AURL, AName: string);
    destructor Destroy; override;
    class function CheckLoginErrors(const ResponseCode: string): Boolean;
    class function IsInternetConnected: Boolean;
    property Name: string read FName write FName;
    property URL: string read FURL write FURL;
    property IdHTTP: TIdHTTP read FIdHTTP;
  end;

var
  Server: TServer;

implementation

uses Windows, SysUtils, Wininet, Dialogs, Lizardry.FormMain, Lizardry.FormInfo,
  Lizardry.FormMsg;

{ TServer }

class function TServer.IsInternetConnected: Boolean;
var
  ConnectionType: DWORD;
begin
  Result := False;
  try
    ConnectionType := INTERNET_CONNECTION_MODEM + INTERNET_CONNECTION_LAN +
      INTERNET_CONNECTION_PROXY;
    Result := InternetGetConnectedState(@ConnectionType, 0);
  except
    ShowMsg('Невозможно подключиться к серверу!');
  end;
end;

class function TServer.CheckLoginErrors(const ResponseCode: string): Boolean;
var
  Code: Byte;
begin
  Result := True;
  Code := StrToIntDef(ResponseCode, 0);
  case Code of
    21:
      ShowMsg('Введите логин!');
    22:
      ShowMsg('Введите пароль!');
    31:
      ShowMsg('Логин не может быть короче 4 символов!');
    32:
      ShowMsg('Пароль не может быть короче 4 символов!');
    41:
      ShowMsg('Логин не должен быть длиннее 24 символов!');
    42:
      ShowMsg('Пароль не должен быть длиннее 24 символов!');
  else
    Result := False;
  end;
end;

constructor TServer.Create(const AURL, AName: string);
begin
  FIdHTTP := TIdHTTP.Create(FormMain);
  FName := AName;
  FURL := AURL;
end;

destructor TServer.Destroy;
begin
  FIdHTTP.Free;
  inherited;
end;

function TServer.Get(AURL: string): string;
begin
  Result := '';
  if not IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  try
    Result := Trim(FIdHTTP.Get('http://' + URL + '/' + Name + '/' + AURL +
      '&username=' + LowerCase(FormMain.FrameLogin.edUserName.Text) +
      '&userpass=' + LowerCase(FormMain.FrameLogin.edUserPass.Text)));
    if Result = '0' then
      ShowMsg('Получен не верный ответ от сервера: 0!');
  except
    on E: Exception do
    begin
      ShowMsg(FIdHTTP.ResponseText);
      ShowError(Result);
    end;
    on E: EIdHTTPProtocolException do
      ShowMsg(E.ErrorMessage);
    on E: EIdHTTPProtocolException do
      ShowMsg(IntToStr(E.ErrorCode));
  end;
end;

function TServer.GetFromDB(const S: string): string;
begin
  Result := FIdHTTP.Get('http://' + URL + '/' + Name + '/' + LowerCase(S)
    + '.php');
end;

{

  procedure TForm1.FormCreate(Sender: TObject);
  var
  ParamList: TStringList;
  ss: TStringStream;
  url: string;
  begin
  ss := TStringStream.Create('', TEncoding.UTF8);
  IdHTTP1 := TIdHTTP.Create();
  ParamList := TStringList.Create;
  try
  ParamList.Add('LoginName=xx');
  ParamList.Add('Password=xx');
  ParamList.Add('SmsKind=808');
  ParamList.Add('ExpSmsId=888');
  url := 'http://...';
  IdHTTP1.Post(url, ParamList, ss);
  Memo1.Text := ss.DataString;
  finally
  ss.Free;
  IdHTTP1.Free;
  ParamList.Free;
  end;
  end;

  function TServer.GetFile: string;
  begin
  Result := FIdHTTP.Get('http://' + URL + '/' + Name + '/characters/character.'
  + LowerCase(FormMain.FrameLogin.edUserName.Text) + '.json');
  end;

}

initialization

Server := TServer.Create('lizardry.pp.ua', 'lizardry');

finalization

Server.Free;

end.
