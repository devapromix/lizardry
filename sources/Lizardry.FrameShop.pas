unit Lizardry.FrameShop;

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
  Vcl.StdCtrls,
  Data.DB,
  Vcl.Grids,
  Vcl.DBGrids;

type
  TShopType = (stWeapon, stArmor, stAlchemy, stMagic, stTavern);

type
  TFrameShop = class(TFrame)
    SG: TStringGrid;
    Panel1: TPanel;
    Label1: TLabel;
    Panel2: TPanel;
    ttInfo: TLabel;
    procedure SGDblClick(Sender: TObject);
    procedure SGKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
    procedure SGClick(Sender: TObject);
  private
    { Private declarations }
  public const
    BuyQuestionMsg = 'Купить %s за %s золотых?';
    BuyURL = 'index.php?action=%s&amount=%s&do=buy&itemslot=%d';
  public
    ShopType: TShopType;
    { Public declarations }
    procedure DrawGrid;
  end;

implementation

{$R *.dfm}

uses
  Math,
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.FormPrompt,
  Lizardry.FormAmountPrompt;

procedure TFrameShop.DrawGrid;
var
  LWidth, LRow: Integer;
begin
  LWidth := FormMain.FrameTown.FrameShop1.Width - 340;
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := LWidth;
  SG.ColWidths[2] := 100;
  SG.ColWidths[3] := 100;
  SG.ColWidths[4] := 100;
  for LRow := 1 to 6 do
  begin
    SG.Cells[0, LRow] := IntToStr(LRow);
    SG.Cells[1, 0] := '';
    SG.Cells[2, 0] := '';
    SG.Cells[3, 0] := '';
    SG.Cells[4, 0] := '';
  end;
  SG.Cells[1, 0] := 'Название';
  SG.Cells[2, 0] := 'Значение';
  SG.Cells[3, 0] := 'Уровень';
  SG.Cells[4, 0] := 'Цена';
  ttInfo.Caption := '';
end;

procedure TFrameShop.SGClick(Sender: TObject);
var
  LRow: Integer;
begin
  if IsChatMode or IsCharMode then
    Exit;
  LRow := SG.Row;
  if (SG.Cells[1, LRow] = '') then
    ttInfo.Caption := ''
  else
    FormMain.FrameTown.ParseJSON
      (Server.Get('index.php?action=shop_item_info&itemslot=' +
      IntToStr(LRow)));
end;

procedure TFrameShop.SGDblClick(Sender: TObject);
var
  LRow: Integer;
begin
  FormAmountPrompt.AmountEdit.Text := '1';
  if IsChatMode or IsCharMode then
    Exit;
  LRow := SG.Row;
  if (SG.Cells[1, LRow] = '') then
    ttInfo.Caption := ''
  else
    case ShopType of
      // Weapon
      stWeapon:
        Prompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow], SG.Cells[4, LRow]]),
          'Купить', 'index.php?action=shop_weapon&do=buy&itemslot=' +
          IntToStr(LRow));
      // Alchemy
      stAlchemy:
        AmountPrompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow],
          SG.Cells[4, LRow]]), 'Купить', 'shop_alchemy',
          FormAmountPrompt.AmountEdit.Text, LRow);
      // Magic
      stMagic:
        AmountPrompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow],
          SG.Cells[4, LRow]]), 'Купить', 'shop_magic',
          FormAmountPrompt.AmountEdit.Text, LRow);
      // Tavern
      stTavern:
        AmountPrompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow],
          SG.Cells[4, LRow]]), 'Купить', 'tavern',
          FormAmountPrompt.AmountEdit.Text, LRow);
      // Armor
    else
      Prompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow], SG.Cells[4, LRow]]),
        'Купить', 'index.php?action=shop_armor&do=buy&itemslot=' +
        IntToStr(LRow));
    end;
end;

procedure TFrameShop.SGKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  if Key = 13 then
    SGDblClick(Sender);
end;

end.
