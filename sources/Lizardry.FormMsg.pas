unit Lizardry.FormMsg;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls, Vcl.Imaging.pngimage,
  Vcl.StdCtrls;

type
  TFormMsg = class(TForm)
    Image1: TImage;
    Panel1: TPanel;
    Panel2: TPanel;
    Button1: TButton;
    Panel3: TPanel;
    Label1: TLabel;
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

procedure ShowMsg(const S: string);
begin
  FormMsg.Label1.Caption := S;
  FormMsg.ShowModal;
end;

end.
