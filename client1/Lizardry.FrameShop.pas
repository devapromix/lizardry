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
  Vcl.Grids;

type
  TShopType = (stWeapon, stArmor, stAlchemy, stMagic, stTavern, stThief);

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
    class function GetHint(const AItemName: string): string;
  end;

implementation

{$R *.dfm}

uses
  Math,
  JSON,
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.FormPrompt,
  Lizardry.FormAmountPrompt,
  Lizardry.FormInfo;

procedure TFrameShop.DrawGrid;
var
  LWidth, LRow: Integer;
begin
  LWidth := FormMain.Width - (FormMain.FrameTown.LeftPanel.Width +
    FormMain.FrameTown.RightPanel.Width + 340);
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
  SG.ColWidths[0] := 30;
  case ShopType of
    stWeapon, stArmor:
      begin
        SG.ColWidths[1] := LWidth;
        SG.ColWidths[2] := 100;
        SG.ColWidths[3] := 100;
      end
  else
    begin
      SG.ColWidths[1] := LWidth + 200;
      SG.ColWidths[2] := 0;
      SG.ColWidths[3] := 0;
    end;
  end;
  SG.ColWidths[4] := 100;
  ttInfo.Caption := '';
end;

class function TFrameShop.GetHint(const AItemName: string): string;
var
  LJSONArray: TJSONArray;
  LJSONObject: TJSONObject;
  I: Integer;
  LItemIdent: Integer;
  LItemName: string;
  LItemLevel: Integer;
  LItemArmor: Integer;
  LItemMinDamage: Integer;
  LItemMaxDamage: Integer;
  LItemDescription: string;
  LItemPrice: Integer;

  function Get(const AName: string; ADef: Integer): Integer;
  begin
    Result := StrToIntDef(LJSONObject.Get(AName).JsonValue.Value, ADef);
  end;

begin
  Result := '';
  LItemIdent := 0;
  LItemName := '';
  LItemLevel := 1;
  LItemArmor := 0;
  LItemMinDamage := 1;
  LItemMaxDamage := 2;
  LItemDescription := '';
  LItemPrice := 0;
  try
    LJSONArray := TJSONObject.ParseJSONValue(FormInfo.ItemMemo.Text)
      as TJSONArray;
    for I := LJSONArray.Count - 1 downto 0 do
    begin
      LJSONObject := TJSONObject(LJSONArray.Get(I));
      LItemName := LJSONObject.Get('item_name').JsonValue.Value;
      if Trim(LItemName) = Trim(AItemName) then
      begin
        LItemIdent := Get('item_ident', 0);
        LItemLevel := Get('item_level', 1);
        LItemArmor := Get('item_armor', 0);
        LItemMinDamage := Get('item_damage_min', 1);
        LItemMaxDamage := Get('item_damage_max', 2);
        LItemPrice := Get('item_price', 0);
        LItemDescription := LJSONObject.Get('item_description').JsonValue.Value;
        Break;
      end;
    end;
  except
  end;
  case LItemIdent of
    1 .. 300:
      begin
        Result := LItemName + '#Доспех. Уровень: ' + IntToStr(LItemLevel) +
          '. Броня: ' + IntToStr(LItemArmor) + '. Цена: ' +
          IntToStr(LItemPrice);
      end;
    301 .. 599:
      begin
        Result := LItemName + '#Одноручное оружие. Уровень: ' +
          IntToStr(LItemLevel) + '. Урон: ' + IntToStr(LItemMinDamage) + '-' +
          IntToStr(LItemMaxDamage) + '. Цена: ' + IntToStr(LItemPrice);
      end;
  else
    begin
      Result := LItemName + '#' + LItemDescription + '. Цена: ' +
        IntToStr(LItemPrice);
    end;
  end;
  Result := Result.Replace('#', #13#10);
end;

procedure TFrameShop.SGClick(Sender: TObject);
begin
  if IsCharMode then
    Exit;
  if (Trim(SG.Cells[1, SG.Row]) = '') then
    ttInfo.Caption := ''
  else
    ttInfo.Caption := TFrameShop.GetHint(Trim(SG.Cells[1, SG.Row]));
end;

procedure TFrameShop.SGDblClick(Sender: TObject);
var
  LRow: Integer;
begin
  FormAmountPrompt.AmountEdit.Text := '1';
  if IsCharMode then
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
      // Black Market
      stThief:
        AmountPrompt(Format(BuyQuestionMsg, [SG.Cells[1, LRow],
          SG.Cells[4, LRow]]), 'Купить', 'black_market',
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
