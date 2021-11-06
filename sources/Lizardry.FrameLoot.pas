unit Lizardry.FrameLoot;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Grids;

type
  TFrameLoot = class(TFrame)
    SG: TStringGrid;
    procedure SGDblClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure DrawGrid;
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.FormPrompt;

{ TFrameLoot }

procedure TFrameLoot.DrawGrid;
var
  W, I: Integer;
begin
  W := FormMain.FrameTown.FrameLoot1.Width - 40;
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := W;
  SG.Cells[1, 0] := 'Название';
end;

procedure TFrameLoot.SGDblClick(Sender: TObject);
var
  I: Integer;
begin
  if IsChatMode or IsCharMode then
    Exit;
  I := SG.Row;
  Prompt(Format('Надеть %s?', [SG.Cells[1, I]]), 'Надеть',
    'index.php?action=pickup_loot&lootslot=' + IntToStr(I));
end;

end.
