unit Lizardry.FrameRegistration;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons;

type
  TFrameRegistration = class(TFrame)
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    edUserName: TEdit;
    edUserPass: TEdit;
    edCharName: TEdit;
    bbRegistration: TBitBtn;
    bbBack: TBitBtn;
    procedure bbBackClick(Sender: TObject);
    procedure bbRegistrationClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure Clear;
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server;

procedure TFrameRegistration.bbBackClick(Sender: TObject);
begin
  FormMain.FrameLogin.BringToFront;
end;

procedure TFrameRegistration.bbRegistrationClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass, CharName: string;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  CharName := Trim(edCharName.Text);
  if not IsInternetConnected then
  begin
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  FormMain.FrameLogin.edUserName.Text := UserName;
  FormMain.FrameLogin.edUserPass.Text := UserPass;
  ResponseCode := Server.GetLocation
    ('registration/registration.php?action=registration&charname=' + CharName);
  FormMain.FrameLogin.edUserPass.Text := '';
  if TServer.CheckLoginErrors(ResponseCode) then Exit;
  if ResponseCode = '1' then
  begin
    ShowMessage('Персонаж с таким именем существует!');
  end
  else if (ResponseCode = '2') then
  begin
    ShowMessage('Регистрация прошла успешно!');
    FormMain.FrameLogin.BringToFront;
  end
  else if (ResponseCode = '23') then
  begin
    ShowMessage('Введите имя персонажа!');
  end
  else if (ResponseCode = '33') then
  begin
    ShowMessage('Имя персонажа не должно быть короче 4 символов!');
  end
  else if (ResponseCode = '43') then
  begin
    ShowMessage('Имя персонажа не должно быть длиннее 24 символов!');
  end
  else
  begin
    ShowMessage('Ошибка регистрации!');
    ShowMessage('Код ошибки: ' + ResponseCode);
  end;
end;

procedure TFrameRegistration.Clear;
begin
  edUserName.Text := '';
  edUserPass.Text := '';
  edCharName.Text := '';
end;

end.
