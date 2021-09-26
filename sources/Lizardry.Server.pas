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

uses Windows, SysUtils, Wininet, Dialogs, Lizardry.FormMain;

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
    ShowMessage('Невозможно подключиться к серверу!');
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
      ShowMessage('Введите логин!');
    22:
      ShowMessage('Введите пароль!');
    31:
      ShowMessage('Логин не может быть короче 4 символов!');
    32:
      ShowMessage('Пароль не может быть короче 4 символов!');
    41:
      ShowMessage('Логин не должен быть длиннее 24 символов!');
    42:
      ShowMessage('Пароль не должен быть длиннее 24 символов!');
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
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  try
    Result := Trim(FIdHTTP.Get('http://' + URL + '/' + Name + '/' + AURL +
      '&username=' + LowerCase(FormMain.FrameLogin.edUserName.Text) +
      '&userpass=' + LowerCase(FormMain.FrameLogin.edUserPass.Text)));
  except
    on E: Exception do
      ShowMessage(FIdHTTP.ResponseText);
    on E: EIdHTTPProtocolException do
      ShowMessage(E.ErrorMessage);
    on E: EIdHTTPProtocolException do
      ShowMessage(IntToStr(E.ErrorCode));
  end;
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
}

initialization

Server := TServer.Create('wallet.pp.ua', 'lizardry');

finalization

Server.Free;

end.
