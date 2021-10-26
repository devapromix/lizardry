﻿unit Lizardry.FrameShop;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls, Data.DB, Vcl.Grids, Vcl.DBGrids;

type
  TShopType = (stWeapon, stArmor);

type
  TFrameShop = class(TFrame)
    SG: TStringGrid;
    Panel1: TPanel;
    Label1: TLabel;
    procedure SGDblClick(Sender: TObject);
    procedure SGKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
  private
    { Private declarations }
  public
    ShopType: TShopType;
    { Public declarations }
    procedure DrawGrid;
    procedure Welcome;
  end;

implementation

{$R *.dfm}

uses Math, Lizardry.FormMain, Lizardry.Server, Lizardry.FormPrompt;

const
  Msg = 'Купить %s за %s золотых?';
  T = 'В моей лавке вы можете купить лучшие товары в в округе!|' +
    'Не спрашивайте меня, где я это достал, просто радуйтесь, что получаете так дешево.|'
    + 'Покупайтете то, что вам нужно, сегодня. Завтра, возможно, нас уже не будет здесь.|'
    + 'Все, что вы видиде, выставлено на продажу. Выбирайте!|' +
    'Я могу протянуть вам руку помощи, если вы протянете мне руку с золотом.|' +
    'Здесь есть предметы, которые могут вам пригодиться в путешествиях. Выбирайте!|'
    + 'Добро пожаловать, путешественник! Не может быть, чтобы ни один из моих товаров не привлек вашего внимания.|'
    + 'Я вижу, вы умеете отличить редкий товар. Пожалуйста, заходите. Выбирайте!|'
    + 'Взгляните на мой товар. Возможно, вам что-то будет полезно.';

procedure TFrameShop.DrawGrid;
var
  W, I: Integer;
begin
  W := FormMain.FrameTown.FrameShop1.Width - 340;
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := W;
  SG.ColWidths[2] := 100;
  SG.ColWidths[3] := 100;
  SG.ColWidths[4] := 100;
  for I := 1 to 6 do
    SG.Cells[0, I] := IntToStr(I);
  SG.Cells[1, 0] := 'Название';
  SG.Cells[2, 0] := 'Броня';
  SG.Cells[3, 0] := 'Уровень';
  SG.Cells[4, 0] := 'Цена';
end;

procedure TFrameShop.SGDblClick(Sender: TObject);
var
  I: Integer;
begin
  if IsChatMode or IsCharMode then
    Exit;
  I := SG.Row;
  case ShopType of
    // Weapon
    stWeapon:
      Prompt(Format(Msg, [SG.Cells[1, I], SG.Cells[4, I]]), 'Купить',
        'index.php?action=shop_weapon&do=buy&itemslot=' + IntToStr(I));
    // Armor
  else
    Prompt(Format(Msg, [SG.Cells[1, I], SG.Cells[4, I]]), 'Купить',
      'index.php?action=shop_armor&do=buy&itemslot=' + IntToStr(I));
  end;
end;

procedure TFrameShop.SGKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  if Key = 13 then
    SGDblClick(Sender);
end;

procedure TFrameShop.Welcome;
var
  S: string;
  R: TArray<string>;
begin
  R := T.Split(['|']);
  S := 'Хозяин лавки:' + #13#10;
  S := S + ' - ' + R[Random(Length(R))] + #13#10;
  Label1.Caption := S;
end;

end.
