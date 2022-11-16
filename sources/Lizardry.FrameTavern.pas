unit Lizardry.FrameTavern;

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
  Vcl.ComCtrls,
  Vcl.Imaging.PNGImage,
  Vcl.ExtCtrls;

type
  TFrameTavern = class(TFrame)
    Edit1: TEdit;
    bbBuy: TBitBtn;
    bbPrice: TBitBtn;
    UpDown1: TUpDown;
    Image1: TImage;
    Image2: TImage;
    procedure bbBuyClick(Sender: TObject);
    procedure bbPriceClick(Sender: TObject);
    procedure Edit1KeyPress(Sender: TObject; var Key: Char);
    procedure Image2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.FormMsg,
  Lizardry.Frame.Location.Town;

procedure TFrameTavern.bbBuyClick(Sender: TObject);
var
  LSum: Integer;
begin
  if IsCharMode then
    Exit;
  LSum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=tavern&do=buy_food_in_tavern&amount=' +
    LSum.ToString));
  Edit1.Text := '0';
end;

procedure TFrameTavern.bbPriceClick(Sender: TObject);
var
  LStr: string;
begin
  LStr := 'Цены на товары и услуги:' + #13#10 +
  //
    'Отдых в Таверне --> ' + IntToStr((RegionLevel * 10) +
    Round((RegionLevel * 10) / 2)) + ' зол.' + #13#10 +
  //
    'Пакет провианта --> ' + IntToStr(RegionLevel * 10) + ' зол.' + #13#10;
  ShowMsg(LStr);
end;

procedure TFrameTavern.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  if IsCharMode then
    Exit;
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['0' .. '9']) then
      Key := #0;
  if Key = #13 then
    bbBuy.Click;
end;

procedure TFrameTavern.Image2Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=town'));
  end;
end;

end.
