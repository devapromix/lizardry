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
  Vcl.ExtCtrls,
  Vcl.Imaging.pngimage;

type
  TFormAmountPrompt = class(TForm)
    bbOK: TSpeedButton;
    bbCancel: TSpeedButton;
    lbMessage: TPanel;
    Label1: TLabel;
    AmountEdit: TEdit;
    sbMinus: TSpeedButton;
    sbPlus: TSpeedButton;
    Panel1: TPanel;
    Image1: TImage;
    procedure bbCancelClick(Sender: TObject);
    procedure bbOKClick(Sender: TObject);
    procedure sbMinusClick(Sender: TObject);
    procedure sbPlusClick(Sender: TObject);
    procedure AmountEditChange(Sender: TObject);
  private
    { Private declarations }
    FRow: Integer;
    FLocation: string;
    FOkLink: string;
    procedure UpdatePrice;
  public
    { Public declarations }
    property Row: Integer read FRow write FRow;
    property Location: string read FLocation write FLocation;
    property OkLink: string read FOkLink write FOkLink;
  end;

procedure AmountPrompt(const ATextMessage, AButOkText, ALocation,
  AItemAmount: string; ARow: Integer);

var
  FormAmountPrompt: TFormAmountPrompt;

implementation

{$R *.dfm}

uses
  Lizardry.Server,
  Lizardry.FormMain,
  Lizardry.FormPrompt,
  Lizardry.FrameShop,
  Lizardry.FormMsg;

procedure AmountPrompt(const ATextMessage, AButOkText, ALocation,
  AItemAmount: string; ARow: Integer);
begin
  FormAmountPrompt.Left := (FormMain.Width div 2) -
    (FormAmountPrompt.Width div 2);
  FormAmountPrompt.Top := (FormMain.Height div 2) -
    (FormAmountPrompt.Height div 2);
  FormAmountPrompt.lbMessage.Caption := ATextMessage;
  FormAmountPrompt.bbOK.Caption := AButOkText;
  FormAmountPrompt.Location := ALocation;
  FormAmountPrompt.Row := ARow;
  FormAmountPrompt.OkLink := Format(TFrameShop.BuyURL,
    [FormAmountPrompt.Location, AItemAmount, FormAmountPrompt.Row]);
  FormAmountPrompt.AmountEdit.SelectAll;
  FormAmountPrompt.ShowModal;
end;

procedure TFormAmountPrompt.AmountEditChange(Sender: TObject);
begin
  UpdatePrice;
end;

procedure TFormAmountPrompt.bbCancelClick(Sender: TObject);
begin
  ModalResult := mrOk;
end;

procedure TFormAmountPrompt.bbOKClick(Sender: TObject);
begin
  if StrToIntDef(AmountEdit.Text, 1) = 0 then
  begin
    ShowMsg('Введите число больше 0!');
    Exit;
  end;
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ModalResult := mrOk;
    ParseJSON(Server.Get(FormAmountPrompt.OkLink));
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
  if (StrToIntDef(AmountEdit.Text, 1) < 99) then
    AmountEdit.Text := IntToStr(StrToIntDef(AmountEdit.Text, 1) + 1);
  UpdatePrice;
end;

procedure TFormAmountPrompt.UpdatePrice;
begin
  with FormMain.FrameTown.FrameShop1 do
    FormAmountPrompt.lbMessage.Caption := Format(TFrameShop.BuyQuestionMsg,
      [SG.Cells[1, SG.Row], IntToStr(StrToIntDef(SG.Cells[4, SG.Row],
      1) * StrToIntDef(AmountEdit.Text, 1))]);
  OkLink := Format(TFrameShop.BuyURL, [Location, AmountEdit.Text, Row]);
end;

end.
