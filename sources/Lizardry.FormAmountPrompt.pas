unit Lizardry.FormAmountPrompt;

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
  Vcl.StdCtrls,
  Vcl.Buttons,
  Vcl.ExtCtrls;

type
  TFormAmountPrompt = class(TForm)
    bbOK: TSpeedButton;
    bbCancel: TSpeedButton;
    lbMessage: TPanel;
    Label1: TLabel;
    AmountEdit: TEdit;
    sbMinus: TSpeedButton;
    sbPlus: TSpeedButton;
    procedure bbCancelClick(Sender: TObject);
    procedure bbOKClick(Sender: TObject);
    procedure sbMinusClick(Sender: TObject);
    procedure sbPlusClick(Sender: TObject);
  private
    { Private declarations }
    OkLink: string;
    procedure UpdatePrice;
  public
    { Public declarations }
  end;

procedure AmountPrompt(const TextMessage, ButOkText, ButOkLink: string);

var
  FormAmountPrompt: TFormAmountPrompt;

implementation

{$R *.dfm}

uses
  Lizardry.Server,
  Lizardry.FormMain,
  Lizardry.FormPrompt,
  Lizardry.FrameShop;

procedure AmountPrompt(const TextMessage, ButOkText, ButOkLink: string);
begin
  FormAmountPrompt.Left := (FormMain.Width div 2) -
    (FormAmountPrompt.Width div 2);
  FormAmountPrompt.Top := (FormMain.Height div 2) -
    (FormAmountPrompt.Height div 2);
  FormAmountPrompt.lbMessage.Caption := TextMessage;
  FormAmountPrompt.bbOK.Caption := ButOkText;
  FormAmountPrompt.AmountEdit.Text := '1';
  FormAmountPrompt.OkLink := ButOkLink;
  FormAmountPrompt.ShowModal;
end;

procedure TFormAmountPrompt.bbCancelClick(Sender: TObject);
begin
  ModalResult := mrOk;
end;

procedure TFormAmountPrompt.bbOKClick(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsChatMode then
      bbChatClick(Sender);
    if IsCharMode then
      bbCharNameClick(Sender);
    ModalResult := mrOk;
    ParseJSON(Server.Get(Format(FormAmountPrompt.OkLink, [])));
  end;
end;

procedure TFormAmountPrompt.sbMinusClick(Sender: TObject);
begin
  if (StrToIntDef(AmountEdit.Text, 1) > 1) then
    AmountEdit.Text := IntToStr(StrToIntDef(AmountEdit.Text, 1) - 1);
  UpdatePrice;
end;

procedure TFormAmountPrompt.sbPlusClick(Sender: TObject);
begin
  if (StrToIntDef(AmountEdit.Text, 1) < 10) then
    AmountEdit.Text := IntToStr(StrToIntDef(AmountEdit.Text, 1) + 1);
  UpdatePrice;
end;

procedure TFormAmountPrompt.UpdatePrice;
begin
  with FormMain.FrameTown.FrameShop1 do
    FormAmountPrompt.lbMessage.Caption :=
      Format(TFrameShop.BuyQuestionMsg, [SG.Cells[1, SG.Row],
      IntToStr(StrToIntDef(SG.Cells[4, SG.Row],
      1) * StrToIntDef(AmountEdit.Text, 1))]);
end;

end.
