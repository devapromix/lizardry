unit Lizardry.FrameChar;

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
  Vcl.ComCtrls,
  Vcl.Grids,
  Vcl.ExtCtrls, Vcl.ButtonGroup, Vcl.Buttons;

type
  TSortType = (siAll, siArmor, siSword, siElixir, siScroll, siAny);

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
    SG: TStringGrid;
    Panel1: TPanel;
    Panel2: TPanel;
    ttInfo: TLabel;
    ttStatBossKills: TLabel;
    imPortret: TImage;
    bbAll: TSpeedButton;
    bbArmor: TSpeedButton;
    bbSword: TSpeedButton;
    bbElixir: TSpeedButton;
    bbScroll: TSpeedButton;
    bbAny: TSpeedButton;
    procedure SGDblClick(Sender: TObject);
    procedure SGClick(Sender: TObject);
    procedure bbAllClick(Sender: TObject);
    procedure bbElixirClick(Sender: TObject);
    procedure bbScrollClick(Sender: TObject);
    procedure bbArmorClick(Sender: TObject);
    procedure bbSwordClick(Sender: TObject);
    procedure bbAnyClick(Sender: TObject);
  private
    { Private declarations }
    ItCount: Integer;
    InvJSON: string;
    procedure SortItems(const ASortType: TSortType);
    function GetItemIndex(const AItemName: string): Integer;
  public
    { Public declarations }
    procedure RefreshInventory(const S: string);
    function GetName(const Id: Integer): string;
    procedure ClearGrid;
    procedure DrawGrid;
  end;

implementation

{$R *.dfm}

uses
  Math,
  JSON,
  Lizardry.FormMain,
  Lizardry.FormInfo,
  Lizardry.Server,
  Lizardry.FrameShop;

{ TFrameChar }

procedure TFrameChar.bbAllClick(Sender: TObject);
begin
  RefreshInventory(InvJSON)
end;

procedure TFrameChar.bbAnyClick(Sender: TObject);
begin
  SortItems(siAny);
end;

procedure TFrameChar.bbArmorClick(Sender: TObject);
begin
  SortItems(siArmor);
end;

procedure TFrameChar.bbElixirClick(Sender: TObject);
begin
  SortItems(siElixir);
end;

procedure TFrameChar.bbScrollClick(Sender: TObject);
begin
  SortItems(siScroll);
end;

procedure TFrameChar.bbSwordClick(Sender: TObject);
begin
  SortItems(siSword);
end;

procedure TFrameChar.ClearGrid;
var
  I: Integer;
begin
  for I := 1 to 100 do
  begin
    SG.Cells[0, I] := '';
    SG.Cells[1, I] := '';
    SG.Cells[2, I] := '';
  end;
end;

procedure TFrameChar.DrawGrid;
var
  LWidth: Integer;
begin
  LWidth := FormMain.Width - (FormMain.FrameTown.LeftPanel.Width +
    FormMain.FrameTown.RightPanel.Width + 140);
  SG.ColWidths[0] := 30;
  SG.ColWidths[1] := LWidth;
  SG.ColWidths[2] := 100;
  ClearGrid;
end;

function TFrameChar.GetItemIndex(const AItemName: string): Integer;
var
  LJSONArray, LInvJSONArray: TJSONArray;
  I, J, LItemIdent, LInvItemIdent: Integer;
  LItemName: string;
begin
  Result := 0;
  try
    LJSONArray := TJSONObject.ParseJSONValue(FormInfo.ItemMemo.Text)
      as TJSONArray;
    for I := LJSONArray.Count - 1 downto 0 do
    begin
      LItemName := TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('item_name'))
        .JsonValue.Value;
      if (LItemName = AItemName) then
      begin
        LItemIdent := StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
          .Get('item_ident')).JsonValue.Value, 0);
        try
          LInvJSONArray := TJSONObject.ParseJSONValue(InvJSON) as TJSONArray;
          for J := 0 to LInvJSONArray.Count - 1 do
          begin
            LInvItemIdent :=
              StrToIntDef(TJSONPair(TJSONObject(LInvJSONArray.Get(J)).Get('id'))
              .JsonValue.Value, 0);
            if (LInvItemIdent = LItemIdent) then
            begin
              Result := J + 1;
              Exit;
            end;
          end;
        except
        end;
      end;
    end;
  except
  end;
end;

function TFrameChar.GetName(const Id: Integer): string;
var
  JSONArray: TJSONArray;
  I, ItemId: Integer;
begin
  Result := '';
  try
    JSONArray := TJSONObject.ParseJSONValue(FormInfo.ItemMemo.Text)
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
  LWidth, I, T: Integer;
  C: string;
  JSONArray: TJSONArray;
begin
  FormInfo.InvMemo.Text := S;
  Self.DrawGrid;
  ttInfo.Caption := '';
  SG.Cells[1, 0] := 'Название';
  InvJSON := S;
  //ShowMessage('INV');
  try
    JSONArray := TJSONObject.ParseJSONValue(InvJSON) as TJSONArray;
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
begin
  if (Trim(SG.Cells[1, SG.Row]) = '') then
    ttInfo.Caption := ''
  else if Math.InRange(SG.Row, 1, ItCount) then
    ttInfo.Caption := TFrameShop.GetHint(Trim(SG.Cells[1, SG.Row]));
end;

procedure TFrameChar.SGDblClick(Sender: TObject);
var
  I, LItemIndex: Integer;
  LItemName: string;
begin
  LItemName := '';
  if (Trim(SG.Cells[1, SG.Row]) = '') then
    LItemName := ''
  else if Math.InRange(SG.Row, 1, ItCount) then
    LItemName := Trim(SG.Cells[1, SG.Row]);
  if Trim(LItemName) <> '' then
    LItemIndex := GetItemIndex(LItemName);
//  ShowMessage(IntToStr(LItemIndex));
  FormMain.FrameTown.ParseJSON(Server.Get('index.php?action=use_item&itemindex='
    + IntToStr(LItemIndex)));
  ttInfo.Caption := '';
end;

procedure TFrameChar.SortItems(const ASortType: TSortType);
var
  LItemCount: string;
  I, J, LItemIdent: Integer;
  LJSONArray: TJSONArray;

  procedure AddItem();
  begin
    LItemCount := TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('count'))
      .JsonValue.Value;
    SG.Cells[0, J] := IntToStr(J);
    SG.Cells[1, J] := GetName(LItemIdent);
    SG.Cells[2, J] := LItemCount + 'x';
  end;

begin
  ClearGrid;
  try
    LJSONArray := TJSONObject.ParseJSONValue(InvJSON) as TJSONArray;
    ItCount := LJSONArray.Count;
    J := 1;
    for I := 0 to LJSONArray.Count - 1 do
    begin
      LItemIdent := StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
        .Get('id')).JsonValue.Value, 0);
      case LItemIdent of
        601 .. 649:
          if ASortType = siElixir then
          begin
            AddItem();
            Inc(J)
          end;
        701 .. 749:
          if ASortType = siScroll then
          begin
            AddItem();
            Inc(J)
          end;
      end;
    end;
  except
    ShowError(InvJSON);
  end;
end;

end.
