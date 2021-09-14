unit Lizardry.FormMain;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Lizardry.FrameLogin, Lizardry.FrameRegistration, Lizardry.Frame.Location.Town;

type
  TFormMain = class(TForm)
    FrameLogin: TFrameLogin;
    FrameRegistration: TFrameRegistration;
    FrameTown: TFrameTown;
    procedure FormCreate(Sender: TObject);
    procedure FormShow(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormMain: TFormMain;

implementation

{$R *.dfm}
{$R images.res}

uses Registry;

procedure TFormMain.FormCreate(Sender: TObject);
begin
  FrameLogin.BringToFront;
end;

procedure TFormMain.FormShow(Sender: TObject);
var
  Reg: TRegistry;
begin
  Reg := TRegistry.Create;
  try
    Reg.RootKey := HKEY_CURRENT_USER;
    Reg.OpenKey('\SOFTWARE\Lizardry', True);
    FrameLogin.edUserName.SetFocus;
    if Reg.ValueExists('UserName') then
    begin
      FrameLogin.edUserName.Text := Reg.ReadString('UserName');
      if Reg.ValueExists('UserPass') then
        FrameLogin.edUserPass.Text := Reg.ReadString('UserPass');
      FrameLogin.edUserPass.SetFocus;
    end;
  finally
    Reg.Free;
  end;
end;

end.
