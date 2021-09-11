unit Lizardry.Frame.Location.Town;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls, Lizardry.FrameBank, Lizardry.FrameDefault;

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
    Panel16: TPanel;
    Panel17: TPanel;
    Panel18: TPanel;
    FrameBank1: TFrameBank;
    FrameDefault1: TFrameDefault;
    FramePanel: TPanel;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
  private
    { Private declarations }
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
  public
    { Public declarations }
    procedure DoAction(S: string);
    procedure ParseJSON(AJSON: string);
  end;

implementation

{$R *.dfm}

uses JSON, Lizardry.FormMain, Lizardry.Server;

procedure TFrameTown.DoAction(S: string);
begin
  ParseJSON(Server.Get(S));
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

procedure TFrameTown.SpeedButton1Click(Sender: TObject);
begin
  FormMain.FrameLogin.BringToFront;
end;

procedure TFrameTown.ClearButtons;
begin
  Panel2.Visible := False;
  Panel3.Visible := False;
  Panel4.Visible := False;
  Panel5.Visible := False;
  Panel6.Visible := False;
end;

procedure TFrameTown.LeftPanelClick(Sender: TObject);
begin
  DoAction((Sender as TPanel).Script);
end;

procedure TFrameTown.ParseJSON(AJSON: string);
var
  JSON: TJSONObject;
  JSONArray: TJSONArray;
  S, Cur, Max: string;
  I: Integer;
begin
  // ShowMessage(AJSON);
  // Exit;
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
    if JSON.TryGetValue('frame', S) then
    begin
      if (S = 'bank') then
        FormMain.FrameTown.FrameBank1.BringToFront;
    end
    else
      FormMain.FrameTown.FrameDefault1.BringToFront;
    //
    if JSON.TryGetValue('refresh', S) then
      if S = 'no_refresh' then
        Exit;
    //
    S := '';
    if JSON.TryGetValue('char_name', S) then
      Panel8.Caption := S;
    if JSON.TryGetValue('char_level', S) then
      Panel11.Caption := 'Уровень: ' + S;
    if JSON.TryGetValue('char_exp', S) then
      Panel13.Caption := 'Опыт: ' + S + '/100';
    if JSON.TryGetValue('char_food', S) then
      Panel15.Caption := 'Провизия: ' + S + '/7';
    if JSON.TryGetValue('char_gold', S) then
      Panel12.Caption := 'Золото: ' + S;
    if JSON.TryGetValue('char_life_cur', Cur) and
      JSON.TryGetValue('char_life_max', Max) then
      Panel14.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('char_mana_cur', Cur) and
      JSON.TryGetValue('char_mana_max', Max) then
      Panel16.Caption := Format('Мана: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('char_damage_min', Cur) and
      JSON.TryGetValue('char_damage_max', Max) then
      Panel17.Caption := Format('Урон: %s-%s', [Cur, Max]);
    if JSON.TryGetValue('char_armor', S) then
      Panel18.Caption := 'Броня: ' + S;
    //
    if JSON.TryGetValue('char_bank', S) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + S;
    // if JSON.TryGetValue('fileroot', S) then
    // ShowMessage(S);
  finally
    JSON.Free;
  end;
end;

end.
