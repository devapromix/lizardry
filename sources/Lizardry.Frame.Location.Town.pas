unit Lizardry.Frame.Location.Town;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls;

type
  TPanel = class(Vcl.ExtCtrls.TPanel)
  private
    FScript: string;
    procedure SetScript(const AScript: string);
    function GetScript: string;
  published
    property Script: string read GetScript write SetScript;
  end;

type
  TFrameTown = class(TFrame)
    Panel7: TPanel;
    Panel8: TPanel;
    Panel11: TPanel;
    Panel12: TPanel;
    Panel13: TPanel;
    Panel14: TPanel;
    Panel15: TPanel;
    Panel1: TPanel;
    Panel2: TPanel;
    Panel3: TPanel;
    Panel4: TPanel;
    Panel5: TPanel;
    Panel6: TPanel;
    bbLogout: TSpeedButton;
    Panel9: TPanel;
    Panel10: TPanel;
    StaticText1: TStaticText;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
  private
    { Private declarations }
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
    procedure DoScript(S: string);
    procedure DoLocation;
    procedure ParseJSON(AJSON: string);
  public
    { Public declarations }
    procedure DoAction(S: string);
  end;

implementation

{$R *.dfm}

uses JSON, Lizardry.FormMain, Lizardry.Server;

procedure TFrameTown.DoAction(S: string);
begin
  with Server do
  begin
    SL.Clear;
    SL.Text := GetLocation(S);
    ParseJSON(SL.Text);
    // DoLocation;
  end;
end;

procedure TFrameTown.AddButton(const Title, Script: string);
begin
  if not Panel2.Visible then
  begin
    Panel2.Top := 1111;
    Panel2.Caption := Title;
    Panel2.Script := Script;
    Panel2.Visible := True;
    Exit;
  end;
  if not Panel3.Visible then
  begin
    Panel3.Top := 1111;
    Panel3.Caption := Title;
    Panel3.Script := Script;
    Panel3.Visible := True;
    Exit;
  end;
  if not Panel4.Visible then
  begin
    Panel4.Top := 1111;
    Panel4.Caption := Title;
    Panel4.Script := Script;
    Panel4.Visible := True;
    Exit;
  end;
  if not Panel5.Visible then
  begin
    Panel5.Top := 1111;
    Panel5.Caption := Title;
    Panel5.Script := Script;
    Panel5.Visible := True;
    Exit;
  end;
  if not Panel6.Visible then
  begin
    Panel6.Top := 1111;
    Panel6.Caption := Title;
    Panel6.Script := Script;
    Panel6.Visible := True;
    Exit;
  end;
end;

procedure TFrameTown.bbLogoutClick(Sender: TObject);
begin

end;

{ TPanel }

function TPanel.GetScript: string;
begin
  Result := FScript;
end;

procedure TPanel.SetScript(const AScript: string);
begin
  FScript := AScript;
end;

procedure TFrameTown.ClearButtons;
begin
  Panel2.Visible := False;
  Panel3.Visible := False;
  Panel4.Visible := False;
  Panel5.Visible := False;
  Panel6.Visible := False;
end;

procedure TFrameTown.DoLocation;
var
  I: Integer;
  L: TArray<string>;
begin
  // Memo1.Text := SL.Text;
  with Server do
    if SL.Count > 0 then
    begin
      ClearButtons;
      for I := 0 to SL.Count - 1 do
      begin
        L := SL[I].Split(['|']);
        case I of
          0:
            begin
              Panel10.Caption := L[0];
              StaticText1.Caption := L[1];
              DoScript(L[2]);
            end;
        else
          begin
            AddButton(L[0], L[1]);
          end;
        end;
      end;
    end;
end;

procedure TFrameTown.DoScript(S: string);
var
  L: TArray<string>;
  Gold: Integer;
  HP, MaxHP: Integer;
begin
  if Trim(S) <> '' then
  begin
    L := S.Split([':']);
    if L[0] = 'all' then
    begin
      Panel8.Caption := L[1];
      Panel11.Caption := Format('Уровень: %s', [L[2]]);
      Panel13.Caption := Format('Опыт: %s/%s', [L[3], '100']);
      Panel15.Caption := Format('Провизия: %s/%s', [L[4], '7']);
      Panel12.Caption := Format('Золото: %s', [L[5]]);
      Panel14.Caption := Format('Здоровье: %s/%s', [L[6], L[7]]);
    end;
    if L[0] = 'rest' then
    begin
      Panel12.Caption := Format('Золото: %s', [L[1]]);
      Panel15.Caption := Format('Провизия: %s/%s', [L[2], '7']);
      Panel14.Caption := Format('Здоровье: %s/%s', [L[3], L[4]]);
    end;
  end;
end;

procedure TFrameTown.LeftPanelClick(Sender: TObject);
begin
  DoAction((Sender as TPanel).Script);
end;

procedure TFrameTown.ParseJSON(AJSON: string);
var
  JSON: TJSONObject;
  JSONArray: TJSONArray;
  S: string;
  I: Integer;
begin
  ShowMessage(AJSON);
  Exit;
  JSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    //
    Panel10.Caption := JSON.Values['title'].Value;
    StaticText1.Caption := JSON.Values['description'].Value;
    //
    ClearButtons;
    JSONArray := TJSONArray(JSON.Get('links').JsonValue);
    for I := 0 to JSONArray.Size - 1 do
    begin
      AddButton(TJSONPair(TJSONObject(JSONArray.Get(I)).Get('title'))
        .JsonValue.Value, TJSONPair(TJSONObject(JSONArray.Get(I)).Get('link'))
        .JsonValue.Value);
    end;
    //
    if JSON.TryGetValue('char_name', S) then
      Panel8.Caption := S;
    if JSON.TryGetValue('char_level', S) then
      Panel11.Caption := 'Уровень: ' + S;
  finally
    JSON.Free;
  end;
end;

procedure TFrameTown.SpeedButton1Click(Sender: TObject);
begin
  FormMain.FrameLogin.edUserPass.Text := '';
  FormMain.FrameLogin.BringToFront;
end;

end.
