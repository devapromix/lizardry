unit Lizardry.Frame.Location.Town;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls, Lizardry.FrameBank, Lizardry.FrameDefault, Lizardry.FrameTavern,
  Lizardry.FrameOutlands, Lizardry.FrameBattle, Lizardry.FrameInfo,
  Lizardry.FrameLoot;

type
  TPanel = class(Vcl.ExtCtrls.TPanel)
  private
    FScript: string;
    procedure SetScript(const AScript: string);
    function GetScript: string;
  published
    property Script: string read GetScript write SetScript;
    function AddToPanel(const ATitle, AScript: string): Boolean;
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
    LinkPanel1: TPanel;
    LinkPanel2: TPanel;
    LinkPanel3: TPanel;
    LinkPanel4: TPanel;
    LinkPanel5: TPanel;
    bbLogout: TSpeedButton;
    Panel9: TPanel;
    Panel10: TPanel;
    Panel16: TPanel;
    Panel17: TPanel;
    Panel18: TPanel;
    FrameBank1: TFrameBank;
    FrameDefault1: TFrameDefault;
    FramePanel: TPanel;
    FrameTavern1: TFrameTavern;
    FrameOutlands1: TFrameOutlands;
    Panel19: TPanel;
    FrameBattle1: TFrameBattle;
    FrameInfo1: TFrameInfo;
    FrameLoot1: TFrameLoot;
    LinkPanel6: TPanel;
    LinkPanel7: TPanel;
    LinkPanel8: TPanel;
    LinkPanel9: TPanel;
    LinkPanel10: TPanel;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
  private
    { Private declarations }
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
  public
    { Public declarations }
    procedure DoAction(S: string);
    procedure ParseJSON(AJSON: string); overload;
    procedure ParseJSON(AJSON, Section: string); overload;
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
  if LinkPanel1.AddToPanel(Title, Script) or LinkPanel2.AddToPanel(Title,
    Script) or LinkPanel3.AddToPanel(Title, Script) or
    LinkPanel4.AddToPanel(Title, Script) or LinkPanel5.AddToPanel(Title, Script)
    or LinkPanel6.AddToPanel(Title, Script) or LinkPanel7.AddToPanel(Title,
    Script) or LinkPanel8.AddToPanel(Title, Script) or
    LinkPanel9.AddToPanel(Title, Script) or LinkPanel10.AddToPanel(Title, Script)
  then
    Exit;
end;

procedure TFrameTown.bbLogoutClick(Sender: TObject);
begin
  FormMain.FrameLogin.BringToFront;
end;

{ TPanel }

function TPanel.AddToPanel(const ATitle, AScript: string): Boolean;
begin
  Result := False;
  if not Self.Visible then
  begin
    Self.Top := High(Word);
    Self.Caption := ATitle;
    Self.Script := AScript;
    Self.Visible := True;
    Result := True;
  end;
end;

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
  LinkPanel1.Visible := False;
  LinkPanel2.Visible := False;
  LinkPanel3.Visible := False;
  LinkPanel4.Visible := False;
  LinkPanel5.Visible := False;
  LinkPanel6.Visible := False;
  LinkPanel7.Visible := False;
  LinkPanel8.Visible := False;
  LinkPanel9.Visible := False;
  LinkPanel10.Visible := False;
end;

procedure TFrameTown.LeftPanelClick(Sender: TObject);
begin
  DoAction((Sender as TPanel).Script);
end;

procedure TFrameTown.ParseJSON(AJSON, Section: string);
var
  JSON: TJSONObject;
  S: string;
begin
  JSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    if UpperCase(Section) = 'ERROR' then
    begin
      if JSON.TryGetValue('error', S) then
        ShowMessage('Ошибка: ' + S);
    end;
    if UpperCase(Section) = 'INFO' then
    begin
      if JSON.TryGetValue('info', S) then
        ShowMessage(S);
    end;
  finally
    JSON.Free;
  end;
end;

procedure TFrameTown.ParseJSON(AJSON: string);
var
  JSON: TJSONObject;
  JSONArray: TJSONArray;
  S, V, Cur, Max: string;
  I: Integer;
begin
  // ShowMessage(AJSON);
  // Exit;
  if AJSON.Contains('{"error":') then
  begin
    ParseJSON(AJSON, 'ERROR');
    Exit;
  end;
  if AJSON.Contains('{"info":') then
  begin
    ParseJSON(AJSON, 'INFO');
    Exit;
  end;
  JSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    if JSON.TryGetValue('log', S) then
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText2.Caption := S
    end
    else
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText2.Caption := '';
    end;
    //
    if JSON.TryGetValue('battlelog', S) then
      with FrameBattle1 do
      begin
        BringToFront;
        RichEdit1.Clear;
        RichEdit1.Lines.Append(S.Replace('#', #13#10));
        SendMessage(RichEdit1.Handle, EM_SCROLL, SB_LINEDOWN, 0);
      end;
    //
    if JSON.TryGetValue('title', S) then
      Panel10.Caption := S;
    if JSON.TryGetValue('description', S) then
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText1.Caption := S;
    end;
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
        FormMain.FrameTown.FrameBank1.BringToFront
      else if (S = 'tavern') then
        FormMain.FrameTown.FrameTavern1.BringToFront
      else if (S = 'outlands') then
        FormMain.FrameTown.FrameOutlands1.BringToFront;
    end
    else
      FormMain.FrameTown.FrameDefault1.BringToFront;
    //
    if JSON.TryGetValue('mainframe', S) then
    begin
      if (S = 'outlands') then
        FormMain.FrameTown.FrameBattle1.BringToFront;
    end
    else
      FormMain.FrameTown.FrameInfo1.BringToFront;
    //
    S := '';
    if JSON.TryGetValue('char_name', S) then
    begin
      Panel8.Caption := S;
      FrameBattle1.Label4.Caption := S;
    end;
    if JSON.TryGetValue('char_level', V) then
      Panel11.Caption := 'Уровень: ' + V;
    if JSON.TryGetValue('char_exp', S) then
      Panel13.Caption := 'Опыт: ' + S + '/' + IntToStr(StrToIntDef(V, 1) * 100);
    if JSON.TryGetValue('char_food', S) then
      Panel15.Caption := 'Провизия: ' + S + '/7';
    if JSON.TryGetValue('char_gold', S) then
      Panel12.Caption := 'Золото: ' + S;
    if JSON.TryGetValue('char_life_cur', Cur) and
      JSON.TryGetValue('char_life_max', Max) then
    begin
      Panel14.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
      FrameBattle1.Label5.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
    end;
    if JSON.TryGetValue('char_mana_cur', Cur) and
      JSON.TryGetValue('char_mana_max', Max) then
      Panel16.Caption := Format('Мана: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('char_damage_min', Cur) and
      JSON.TryGetValue('char_damage_max', Max) then
    begin
      Panel17.Caption := Format('Урон: %s-%s', [Cur, Max]);
      FrameBattle1.Label6.Caption := Format('Урон: %s-%s', [Cur, Max]);
    end;
    if JSON.TryGetValue('char_armor', S) then
      Panel18.Caption := 'Броня: ' + S;
    //
    if JSON.TryGetValue('char_bank', S) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + S;
    if JSON.TryGetValue('enemy_life_cur', Cur) and
      JSON.TryGetValue('enemy_life_max', Max) then
      FrameBattle1.Label2.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('enemy_damage_min', Cur) and
      JSON.TryGetValue('enemy_damage_max', Max) then
      FrameBattle1.Label3.Caption := Format('Урон: %s-%s', [Cur, Max]);

    // if JSON.TryGetValue('fileroot', S) then
    // ShowMessage(S);
  finally
    JSON.Free;
  end;
end;

end.
