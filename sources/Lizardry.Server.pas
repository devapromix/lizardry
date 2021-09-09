unit Lizardry.Server;

interface

uses idHTTP, Classes;

type
  TServer = class(TObject)
  private
    FURL: string;
    FS: TidHTTP;
  public
    SL: TStringList;
    function GetLocation(AURL: string): string;
    constructor Create;
    destructor Destroy; override;
    class function CheckLoginErrors(const ResponseCode: string): Boolean;
  end;

function IsInternetConnected: Boolean;

var
  Server: TServer;

implementation

uses Forms, Windows, SysUtils, Wininet, Dialogs, Lizardry.FormMain;

const
  ServerURL = 'http://wallet.pp.ua/lizardry/';

  { TServer }

function IsInternetConnected: Boolean;
var
  ConnectionType: DWORD;

begin
  Result := False;
  try
    ConnectionType := INTERNET_CONNECTION_MODEM + INTERNET_CONNECTION_LAN +
      INTERNET_CONNECTION_PROXY;
    Result := InternetGetConnectedState(@ConnectionType, 0);
  except
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

constructor TServer.Create;
begin
  FS := TidHTTP.Create(nil);
  FURL := ServerURL;
  SL := TStringList.Create;
end;

destructor TServer.Destroy;
begin
  SL.Free;
  FS.Free;
  inherited;
end;

function TServer.GetLocation(AURL: string): string;
begin
  if not IsInternetConnected then
  begin
    Result := '';
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  try
    Result := Trim(FS.Get(FURL + AURL + '&username=' +
      LowerCase(FormMain.FrameLogin.edUserName.Text) + '&userpass=' +
      LowerCase(FormMain.FrameLogin.edUserPass.Text)));
  except
    on E: Exception do
    begin
      Result := '';
      ShowMessage(FS.ResponseText);
    end;
  end;
end;

initialization

Server := TServer.Create;

finalization

Server.Free;

end.
