unit Lizardry.FormPrompt;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons, Vcl.ExtCtrls;

type
  TFormPrompt = class(TForm)
    bbOK: TSpeedButton;
    bbCancel: TSpeedButton;
    lbMessage: TPanel;
    procedure bbCancelClick(Sender: TObject);
    procedure bbOKClick(Sender: TObject);
  private
    { Private declarations }
    OkLink: string;
  public
    { Public declarations }
  end;

procedure Prompt(const TextMessage, ButOkText, ButOkLink: string);

var
  FormPrompt: TFormPrompt;

implementation

{$R *.dfm}

uses Lizardry.Server, Lizardry.FormMain;

procedure Prompt(const TextMessage, ButOkText, ButOkLink: string);
begin
  FormPrompt.Left := (FormMain.Width div 2) - (FormPrompt.Width div 2);
  FormPrompt.Top := (FormMain.Height div 2) - (FormPrompt.Height div 2);
  FormPrompt.lbMessage.Caption := TextMessage;
  FormPrompt.bbOK.Caption := ButOkText;
  FormPrompt.OkLink := ButOkLink;
  FormPrompt.ShowModal;
end;

procedure TFormPrompt.bbCancelClick(Sender: TObject);
begin
  ModalResult := mrOk;
end;

procedure TFormPrompt.bbOKClick(Sender: TObject);
begin
  ModalResult := mrOk;
  FormMain.FrameTown.ParseJSON(Server.Get(FormPrompt.OkLink));
end;

end.
