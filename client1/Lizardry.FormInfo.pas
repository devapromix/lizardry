unit Lizardry.FormInfo;

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
  Vcl.ExtCtrls;

type
  TFormInfo = class(TForm)
    PageControl1: TPageControl;
    TabSheet1: TTabSheet;
    LocMemo: TRichEdit;
    TabSheet2: TTabSheet;
    ItemMemo: TRichEdit;
    TabSheet3: TTabSheet;
    ResMemo: TMemo;
    ImagesPath: TPanel;
    TabSheet4: TTabSheet;
    ErrorMemo: TMemo;
    TabSheet5: TTabSheet;
    InvMemo: TMemo;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormInfo: TFormInfo;

type
  RItemInfo = record
    Ident: Integer;
    Name: string;
    Description: string;
  end;

procedure MsgBox(const S: string);
procedure InvJSON(const S: string);
procedure ShowError(const S: string);
function GetItemInfo(const AItemName: string): RItemInfo;
function GetHint(const AItemInfo: RItemInfo): string;

implementation

uses
  JSON;

{$R *.dfm}

procedure MsgBox(const S: string);
begin
  FormInfo.LocMemo.Clear;
  FormInfo.LocMemo.Lines.Append(S);
end;

procedure ShowError(const S: string);
begin
  FormInfo.ErrorMemo.Clear;
  FormInfo.ErrorMemo.Lines.Append(S);
end;

procedure InvJSON(const S: string);
begin
  FormInfo.InvMemo.Clear;
  FormInfo.InvMemo.Lines.Append(S);
end;

function GetItemInfo(const AItemName: string): RItemInfo;
var
  LJSONArray: TJSONArray;
  I: Integer;
begin
  begin
    Result.Ident := 0;
    Result.Name := '';
    Result.Description := '';
    try
      LJSONArray := TJSONObject.ParseJSONValue(FormInfo.ItemMemo.Text)
        as TJSONArray;
      for I := LJSONArray.Count - 1 downto 0 do
      begin
        Result.Name := TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('item_name')
          ).JsonValue.Value;
        if Trim(Result.Name) = Trim(AItemName) then
        begin
          Result.Ident :=
            StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
            .Get('item_ident')).JsonValue.Value, 0);
          Result.Description := TJSONPair(TJSONObject(LJSONArray.Get(I))
            .Get('item_description')).JsonValue.Value;
          Exit;
        end;
      end;
    except
    end;
  end;
end;

function GetHint(const AItemInfo: RItemInfo): string;
begin
  Result := AItemInfo.Name + '#' + AItemInfo.Description;
  Result := Result.Replace('#', #13#10);
end;

end.
