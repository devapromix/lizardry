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
    Panel2: TPanel;
    ttInfo: TLabel;
    procedure SGDblClick(Sender: TObject);
    procedure SGClick(Sender: TObject);
  private
    { Private declarations }
    ItCount: Integer;
  public
    { Public declarations }
    procedure RefreshInventory(const S: string);
    function GetName(const Id: Integer): string;
  end;

implementation

{$R *.dfm}

uses Math, JSON, Lizardry.FormMain, Lizardry.FormInfo, Lizardry.Server;

{ TFrameChar }

function TFrameChar.GetName(const Id: Integer): string;
var
  JSONArray: TJSONArray;
  I, ItemId: Integer;
begin
  Result := '';
  try
    JSONArray := TJSONObject.ParseJSONValue(FormInfo.RichEdit2.Text)
      as TJSONArray;
    for I := JSONArray.Count - 1 downto 0 do
    begin
      ItemId := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I))
        .Get('item_ident')).JsonValue.Value, 0);
      if ItemId = Id then
      begin
        Result := TJSONPair(TJSONObject(JSONArray.Get(I)).Get('item_name'))
          .JsonValue.Value;
      end;
    end;
  except
  end;
end;

procedure TFrameChar.RefreshInventory(const S: string);
var
  W, I, T: Integer;
  C: string;
  JSONArray: TJSONArray;
begin
  W := FormMain.FrameTown.FrameShop1.Width - 140;
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := W;
  SG.ColWidths[2] := 100;
  ttInfo.Caption := '';

  for I := 1 to 16 do
  begin
    SG.Cells[0, I] := '';
    SG.Cells[1, I] := '';
    SG.Cells[2, I] := '';
  end;
  SG.Cells[1, 0] := 'Название';

  try
    JSONArray := TJSONObject.ParseJSONValue(S) as TJSONArray;
    ItCount := JSONArray.Count;
    for I := 0 to JSONArray.Count - 1 do
    begin
      T := StrToIntDef(TJSONPair(TJSONObject(JSONArray.Get(I)).Get('id'))
        .JsonValue.Value, 0);
      C := TJSONPair(TJSONObject(JSONArray.Get(I)).Get('count'))
        .JsonValue.Value;
      SG.Cells[0, I + 1] := IntToStr(I + 1);
      SG.Cells[1, I + 1] := GetName(T);
      SG.Cells[2, I + 1] := C + 'x';
    end;
    Panel1.Caption := Format('%d/' + IntToStr(SG.RowCount - 1),
      [JSONArray.Count]);
  except
    ShowError(S);
  end;
end;

procedure TFrameChar.SGClick(Sender: TObject);
var
  I: Integer;
begin
  I := SG.Row;
  if Math.InRange(I, 1, ItCount) then
    FormMain.FrameTown.ParseJSON
      (Server.Get('index.php?action=item_info&itemindex=' + IntToStr(I)))
  else
    ttInfo.Caption := '';
end;

procedure TFrameChar.SGDblClick(Sender: TObject);
var
  I: Integer;
begin
  I := SG.Row;
  if Math.InRange(I, 1, ItCount) then
    FormMain.FrameTown.ParseJSON
      (Server.Get('index.php?action=use_item&itemindex=' + IntToStr(I)));
  ttInfo.Caption := '';
end;

end.
