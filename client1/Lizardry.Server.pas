unit Lizardry.Server;

interface

uses
  IdHTTP,
  Classes;

type
  TServer = class(TObject)
  private
    FIdHTTP: TIdHTTP;
    FName: string;
    FURL: string;
    function CheckJSON(AJSON: string): Boolean;
  public
    function Get(AURL: string): string;
    constructor Create(const AURL, AName: string);
    destructor Destroy; override;
    class function IsInternetConnected: Boolean;
    property Name: string read FName write FName;
    property URL: string read FURL write FURL;
    property IdHTTP: TIdHTTP read FIdHTTP;
    function MD5(const AStr: string): string;
  end;

var
  Server: TServer;

implementation

uses
  Windows,
  SysUtils,
  Wininet,
  Dialogs,
  IdHashMessageDigest,
  Lizardry.FormMain,
  Lizardry.FormInfo,
  Lizardry.FormMsg,
  Lizardry.FrameLogin;

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

function TServer.MD5(const AStr: string): string;
begin
  Result := '';
  with TIdHashMessageDigest5.Create do
    try
      Result := AnsiLowerCase(HashStringAsHex(AStr));
    finally
      Free;
    end;
end;

function TServer.CheckJSON(AJSON: string): Boolean;
begin
  Result := (AJSON.StartsWith('{') and AJSON.EndsWith('}')) or
    (AJSON.StartsWith('[') and AJSON.EndsWith(']'));
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
var
  LURL: string;
begin
  Result := '';
  if not IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  try
    LURL := 'http://' + URL + '/' + Name + '/' + AURL + '&username=' +
      LowerCase(FormMain.FrameLogin.edUserName.Text) + '&userpass=' +
      MD5(LowerCase(FormMain.FrameLogin.edUserPass.Text)) + '&usersession=' +
      LowerCase(UserSession);
    FormMain.StatusBar.SimpleText := LURL;
    if not CheckJSON(Result) then
    begin
      ShowError(Result);
      Result := '{"error":"Неверный ответ от сервера!"}';
    end;
    Result := Trim(FIdHTTP.Get(LURL));
  except
    on E: Exception do
    begin
      ShowMsg(FIdHTTP.ResponseText + #13#10 + Result);
      ShowError(Result);
    end;
    on E: EIdHTTPProtocolException do
      ShowMsg(E.ErrorMessage);
    on E: EIdHTTPProtocolException do
      ShowMsg(IntToStr(E.ErrorCode));
  end;
end;

initialization

Server := TServer.Create('lizardry.pp.ua', 'lizardry');

finalization

Server.Free;

end.
