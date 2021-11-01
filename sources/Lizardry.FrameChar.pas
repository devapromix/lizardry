unit Lizardry.FrameChar;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls,
  Vcl.ComCtrls,
  Vcl.Grids, Vcl.ExtCtrls;

type
  TFrameChar = class(TFrame)
    ttStatKills: TLabel;
    PageControl1: TPageControl;
    TabSheet1: TTabSheet;
    TabSheet2: TTabSheet;
    TabSheet3: TTabSheet;
    ttStatDeads: TLabel;
    ttWeapon: TLabel;
    ttArmor: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    TabSheet4: TTabSheet;
    SG: TStringGrid;
    Panel1: TPanel;
    procedure Panel1Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure RefreshInventory(const S: string);
    function GetItemJSON(): string;
  end;

implementation

{$R *.dfm}

uses JSON, Lizardry.FormMain, Lizardry.FormInfo;

{ TFrameChar }

function TFrameChar.GetItemJSON: string;
var
  JSONArray: TJSONArray;
  I: Integer;
begin
  JSONArray := TJSONArray(FormInfo.RichEdit2.Text);
  for I := 0 to JSONArray.Count - 1 do
  begin
//    AddButton(TJSONPair(TJSONObject(JSONArray.Get(I)).Get('title'))
//      .JsonValue.Value, TJSONPair(TJSONObject(JSONArray.Get(I)).Get('link'))
//      .JsonValue.Value);
  end;

end;

procedure TFrameChar.Panel1Click(Sender: TObject);
begin
  RefreshInventory('0-1-1=1,0-2-1=8,0-3-4=6,0-12-2=4');
end;

procedure TFrameChar.RefreshInventory(const S: string);
var
  N, T: TArray<string>;
  W, I: Integer;
begin
  W := FormMain.FrameTown.FrameShop1.Width - 140;
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := W;
  SG.ColWidths[2] := 100;

  for I := 1 to 16 do
  begin
    SG.Cells[0, I] := '';
    SG.Cells[1, I] := '';
  end;
  SG.Cells[1, 0] := 'Название';

  N := S.Split([',']);
  for I := 0 to Length(N) - 1 do
  begin
    T := N[I].Split(['=']);
    SG.Cells[0, I + 1] := IntToStr(I + 1);
    SG.Cells[1, I + 1] := T[0];
    SG.Cells[2, I + 1] := T[1] + 'x';
  end;
  Panel1.Caption := Format('%d/15', [Length(N)]);
end;

end.
