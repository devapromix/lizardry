unit Lizardry.FrameLogin;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls, Vcl.Buttons, Vcl.Imaging.pngimage;

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
    Label3: TLabel;
    procedure bbRegistrationClick(Sender: TObject);
    procedure bbLoginClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Registry, Lizardry.FormMain, Lizardry.Server, Lizardry.Frame.Location.Town,
  Lizardry.Game;

procedure TFrameLogin.bbLoginClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass: string;
  Reg: TRegistry;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  if not TServer.IsInternetConnected then
  begin
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  ResponseCode := Server.Get('index.php?action=login');
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '0' then
  begin
    ShowMessage('Ошибка авторизации!');
    Exit;
  end
  else if ResponseCode = '1' then
  begin
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
      finally
        Reg.Free;
      end;
    end;
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

end.
