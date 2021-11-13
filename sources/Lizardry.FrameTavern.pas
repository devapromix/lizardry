unit Lizardry.FrameTavern;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ComCtrls;

type
  TFrameTavern = class(TFrame)
    Edit1: TEdit;
    bbBuy: TBitBtn;
    bbPrice: TBitBtn;
    UpDown1: TUpDown;
    procedure bbBuyClick(Sender: TObject);
    procedure bbPriceClick(Sender: TObject);
    procedure Edit1KeyPress(Sender: TObject; var Key: Char);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server, Lizardry.FormMsg,
  Lizardry.Frame.Location.Town;

procedure TFrameTavern.bbBuyClick(Sender: TObject);
var
  Sum: Integer;
begin
  if IsChatMode or IsCharMode then
    Exit;
  Sum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=tavern&do=buy_food_in_tavern&amount=' +
    Sum.ToString));
  Edit1.Text := '0';
end;

procedure TFrameTavern.bbPriceClick(Sender: TObject);
var
  S: string;
begin
  {
    1. 15 - 10  70
    2. 30 - 20  140
    3. 45 - 30  210
    4. 60 - 40  280
    5. 75 - 50  350
  }
  S := 'Цены на товары и услуги:' + #13#10 +
  //
    'Отдых в Таверне --> ' + IntToStr((RegionLevel * 10) +
    Round((RegionLevel * 10) / 2)) + ' зол.' + #13#10 +
  //
    'Пакет провианта --> ' + IntToStr(RegionLevel * 10) + ' зол.' + #13#10;
  ShowMsg(S);
end;

procedure TFrameTavern.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  if IsChatMode or IsCharMode then
    Exit;
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['0' .. '9']) then
      Key := #0;
  if Key = #13 then
    bbBuy.Click;
end;

end.
