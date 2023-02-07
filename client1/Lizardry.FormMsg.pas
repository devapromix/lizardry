unit Lizardry.FormMsg;

interface

uses
  Winapi.Windows,
  Winapi.Messages,
  System.SysUtils,
  System.Variants,
  System.Classes,
  Vcl.Graphics,
  Vcl.Controls,
  Vcl.Forms,
  Vcl.Dialogs,
  Vcl.ExtCtrls,
  Vcl.Imaging.pngimage,
  Vcl.StdCtrls;

type
  TFormMsg = class(TForm)
    Panel1: TPanel;
    Panel2: TPanel;
    Button1: TButton;
    lblText: TLabel;
    Panel5: TPanel;
    Image1: TImage;
    Timer1: TTimer;
    procedure Timer1Timer(Sender: TObject);
    procedure Button1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormMsg: TFormMsg;

procedure ShowMsg(const AStr: string; const ADelay: Integer = 0);

implementation

{$R *.dfm}

uses
  Lizardry.FormMain,
  Lizardry.Server;

procedure ShowMsg(const AStr: string; const ADelay: Integer = 0);
begin
  if Trim(AStr) = '' then
    Exit;
  FormMsg.Left := (FormMain.Width div 2) - (FormMsg.Width div 2);
  FormMsg.Top := (FormMain.Height div 2) - (FormMsg.Height div 2);
  FormMsg.lblText.Caption := Trim(AStr).Replace('#', #13#10);
  with FormMsg do
    if ADelay = 0 then
      ShowModal
    else
    begin
      Timer1.Interval := ADelay;
      Timer1.Enabled := True;
    end;
end;

procedure TFormMsg.Button1Click(Sender: TObject);
begin
  Server.Get('index.php?action=clear');
end;

procedure TFormMsg.Timer1Timer(Sender: TObject);
begin
  Timer1.Enabled := False;
  FormMsg.ShowModal;
end;

end.
