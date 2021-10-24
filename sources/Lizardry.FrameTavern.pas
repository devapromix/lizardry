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

uses Lizardry.FormMain, Lizardry.Server, Lizardry.FormMsg;

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
  S := 'Цены на товары и услуги:' + #13#10 +
  //
    'Ночь в Таверне --> 15 зол.' + #13#10 +
  //
    'Пакет провианта --> 10 зол.' + #13#10;
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
