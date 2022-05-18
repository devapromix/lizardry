unit Lizardry.FormMsg;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls, Vcl.Imaging.pngimage,
  Vcl.StdCtrls;

type
  TFormMsg = class(TForm)
    Panel1: TPanel;
    Panel2: TPanel;
    Button1: TButton;
    Panel3: TPanel;
    Label1: TLabel;
    Panel5: TPanel;
    Image1: TImage;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormMsg: TFormMsg;

procedure ShowMsg(const S: string);

implementation

{$R *.dfm}

uses Lizardry.FormMain;

procedure ShowMsg(const S: string);
begin
  FormMsg.Left := (FormMain.Width div 2) - (FormMsg.Width div 2);
  FormMsg.Top := (FormMain.Height div 2) - (FormMsg.Height div 2);
  FormMsg.Label1.Caption := S;
  FormMsg.ShowModal;
end;

end.
