unit Lizardry.FormMain;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Lizardry.FrameLogin, Lizardry.FrameRegistration, Lizardry.Frame.Location.Town,
  IdAntiFreezeBase, IdAntiFreeze, IdBaseComponent, IdComponent, IdTCPConnection,
  IdTCPClient, IdHTTP, Lizardry.FrameUpdate;

type
  TFormMain = class(TForm)
    FrameLogin: TFrameLogin;
    FrameRegistration: TFrameRegistration;
    FrameTown: TFrameTown;
    FrameUpdate: TFrameUpdate;
    procedure FormCreate(Sender: TObject);
    procedure FormShow(Sender: TObject);
    procedure FormResize(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormMain: TFormMain;
  IsChatMode: Boolean = False;
  IsCharMode: Boolean = False;
  IsDebugMode: Boolean = False;

implementation

{$R *.dfm}

uses Registry, Lizardry.FormInfo, Lizardry.FormMsg;

procedure TFormMain.FormCreate(Sender: TObject);
var
  I: Integer;
begin
  for I := 1 to ParamCount do
    if ParamStr(I) = '-debug' then
      IsDebugMode := True;
  FrameLogin.BringToFront;
end;

procedure TFormMain.FormResize(Sender: TObject);
begin
  FrameTown.FrameShop1.DrawGrid;
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
    if Reg.ValueExists('Server') then
      FrameLogin.ComboBox1.ItemIndex := Reg.ReadInteger('Server')
    else
      FrameLogin.ComboBox1.ItemIndex := 0;
    FrameLogin.ComboBox1Change(Sender);
  finally
    Reg.Free;
  end;
end;

end.
