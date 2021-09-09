unit Lizardry.FrameLogin;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls, Vcl.Buttons;

type
  TFrameLogin = class(TFrame)
    Panel1: TPanel;
    edUserName: TEdit;
    bbLogin: TBitBtn;
    Label1: TLabel;
    Label2: TLabel;
    bbRegistration: TBitBtn;
    edUserPass: TEdit;
    procedure bbRegistrationClick(Sender: TObject);
    procedure bbLoginClick(Sender: TObject);
    procedure edUserPassClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server, Lizardry.Frame.Location.Town,
  Lizardry.Game;

procedure TFrameLogin.bbLoginClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass: string;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  if not IsInternetConnected then
  begin
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  ResponseCode := Server.GetLocation('index.php?action=login');
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '0' then
  begin
    ShowMessage('Ошибка авторизации!');
    Exit;
  end
  else if ResponseCode = '1' then
  begin
    FormMain.FrameTown.DoAction('index.php?action=in_town');
    FormMain.FrameTown.BringToFront;
  end
  else
  begin
    ShowMessage('Ошибка авторизации!');
    Exit;
  end;
end;

procedure TFrameLogin.bbRegistrationClick(Sender: TObject);
begin
  FormMain.FrameRegistration.Clear;
  FormMain.FrameRegistration.BringToFront;
end;

procedure TFrameLogin.EnterKeyPress(Sender: TObject; var Key: Char);
begin
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['a' .. 'z', 'A' .. 'Z', '0' .. '9', '_']) then
      Key := #0;
  if Key = #13 then
    bbLogin.Click;
end;

procedure TFrameLogin.edUserPassClick(Sender: TObject);
begin
  edUserPass.PasswordChar := #0;
end;

end.
