unit Lizardry.FrameTavern;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons;

type
  TFrameTavern = class(TFrame)
    Edit1: TEdit;
    bbDeposit: TBitBtn;
    bbPrice: TBitBtn;
    procedure bbDepositClick(Sender: TObject);
    procedure bbPriceClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server;

procedure TFrameTavern.bbDepositClick(Sender: TObject);
var
  Sum: Integer;
begin
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
  ShowMessage(S);
end;

end.
