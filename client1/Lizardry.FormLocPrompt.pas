unit Lizardry.FormLocPrompt;

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
  Vcl.Buttons,
  Vcl.ExtCtrls;

type
  TFormLocPrompt = class(TForm)
    lbMessage: TPanel;
    bbOK: TSpeedButton;
    bbCancel: TSpeedButton;
    procedure bbOKClick(Sender: TObject);
    procedure bbCancelClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormLocPrompt: TFormLocPrompt;

procedure LocPrompt;

implementation

{$R *.dfm}

uses
  Lizardry.Server,
  Lizardry.Frame.Location.Town,
  Lizardry.FormMain;

procedure LocPrompt;
begin
  FormLocPrompt.Left := (FormMain.Width div 2) - (FormLocPrompt.Width div 2);
  FormLocPrompt.Top := (FormMain.Height div 2) - (FormLocPrompt.Height div 2);
  FormLocPrompt.ShowModal;
end;

procedure TFormLocPrompt.bbCancelClick(Sender: TObject);
begin
  ModalResult := mrCancel;
end;

procedure TFormLocPrompt.bbOKClick(Sender: TObject);
begin
  ModalResult := mrOk;
  with FormMain.FrameTown do
    ParseJSON(Server.Get('index.php?action=' + CurrentOutlands));
end;

end.
