unit Lizardry.FrameShop;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls, Data.DB, Vcl.Grids, Vcl.DBGrids;

type
  TFrameShop = class(TFrame)
    SG: TStringGrid;
    procedure SGDblClick(Sender: TObject);
    procedure SGKeyDown(Sender: TObject; var Key: Word; Shift: TShiftState);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure DrawGrid;
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server, Lizardry.FormPrompt;

const
  Msg = 'Купить %s за %s золотых?';

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
  Prompt(Format(Msg, [SG.Cells[1, I], SG.Cells[4, I]]), 'Купить',
    'index.php?action=shop_armor&do=buy&itemslot=' + IntToStr(I));
end;

procedure TFrameShop.SGKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  if Key = 13 then
    SGDblClick(Sender);
end;

end.
