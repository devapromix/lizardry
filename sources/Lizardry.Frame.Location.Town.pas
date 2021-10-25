﻿unit Lizardry.Frame.Location.Town;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls, Lizardry.FrameBank, Lizardry.FrameDefault, Lizardry.FrameTavern,
  Lizardry.FrameOutlands, Lizardry.FrameBattle, Lizardry.FrameInfo,
  Lizardry.FrameLoot, Lizardry.FrameChat, Lizardry.FrameShop,
  Lizardry.FrameChar;

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
    RightPanel: TPanel;
    CharNamePanel: TPanel;
    Panel11: TPanel;
    Panel12: TPanel;
    Panel13: TPanel;
    Panel14: TPanel;
    Panel15: TPanel;
    LeftPanel: TPanel;
    LinkPanel1: TPanel;
    LinkPanel2: TPanel;
    LinkPanel3: TPanel;
    LinkPanel4: TPanel;
    LinkPanel5: TPanel;
    bbLogout: TSpeedButton;
    MainPanel: TPanel;
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
    bbDebug: TSpeedButton;
    FrameChat: TFrameChat;
    bbChat: TSpeedButton;
    pnEqWeapon: TPanel;
    pnEqArmor: TPanel;
    FrameShop1: TFrameShop;
    HPPanel: TPanel;
    Panel1: TPanel;
    bbCharName: TSpeedButton;
    FrameChar: TFrameChar;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
    procedure bbDebugClick(Sender: TObject);
    procedure bbChatClick(Sender: TObject);
    procedure bbCharNameClick(Sender: TObject);
  private
    { Private declarations }
    Title: string;
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
  public
    { Public declarations }
    procedure ShowChat;
    procedure HideChat;
    procedure ShowChar;
    procedure HideChar;
    procedure DoAction(S: string);
    procedure ParseJSON(AJSON: string); overload;
    procedure ParseJSON(AJSON, Section: string); overload;
    function IsActPanels: Boolean;
  end;

implementation

{$R *.dfm}

uses Math, JSON, Lizardry.FormMain, Lizardry.Server, Lizardry.FormInfo,
  Lizardry.FormMsg;

var
  LastCode: string = '';

procedure TFrameTown.DoAction(S: string);
begin
  ParseJSON(Server.Get(S));
end;

procedure TFrameTown.HideChar;
begin
  Panel10.Caption := Title;
  FrameChar.SendToBack;
  IsCharMode := False;
end;

procedure TFrameTown.HideChat;
begin
  FrameChat.edChatMsg.Text := '';
  Panel10.Caption := Title;
  FrameChat.SendToBack;
  IsChatMode := False;
end;

function TFrameTown.IsActPanels: Boolean;
begin
  //
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
  HideChat;
  FormMain.FrameLogin.LoadLastEvents;
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
  bbDebug.Visible := IsDebugMode;
end;

procedure TFrameTown.LeftPanelClick(Sender: TObject);
begin
  if IsChatMode or IsCharMode then
    Exit;
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
        ShowMsg('Ошибка: ' + S);
    end;
    if UpperCase(Section) = 'INFO' then
    begin
      if JSON.TryGetValue('info', S) then
        ShowMsg(S);
    end;
  finally
    JSON.Free;
  end;
end;

procedure TFrameTown.ShowChar;
begin
  if IsChatMode then
    HideChat;
  Title := Panel10.Caption;
  Panel10.Caption := bbCharName.Caption;
  FrameChar.PageControl1.ActivePageIndex := 0;
  FrameChar.BringToFront;
  IsCharMode := True;
end;

procedure TFrameTown.ShowChat;
begin
  if IsCharMode then
    HideChar;
  FrameChat.edChatMsg.Text := '';
  FrameChat.edChatMsg.SetFocus;
  Title := Panel10.Caption;
  Panel10.Caption := 'ЧАТ';
  FrameChat.BringToFront;
  IsChatMode := True;
end;

procedure TFrameTown.ParseJSON(AJSON: string);
var
  JSON: TJSONObject;
  JSONArray: TJSONArray;
  S, V, Cur, Max, Code: string;
  I, F, J, K: Integer;
  A: TArray<string>;
begin
  MsgBox(AJSON);
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
      FrameInfo1.StaticText1.Caption := S.Replace('#', #13#10);
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
      begin
        if JSON.TryGetValue('char_gold', S) then
        begin
          F := StrToIntDef(S, 0);
          FormMain.FrameTown.FrameBank1.Edit1.Text := IntToStr(F);
        end;
        FormMain.FrameTown.FrameBank1.BringToFront;
      end
      else if (S = 'tavern') then
      begin
        if JSON.TryGetValue('char_food', S) then
        begin
          F := StrToIntDef(S, 0);
          F := EnsureRange(7 - F, 0, 7);
          FormMain.FrameTown.FrameTavern1.Edit1.Text := IntToStr(F);
        end;
        FormMain.FrameTown.FrameTavern1.BringToFront;
      end
      else if (S = 'outlands') then
      begin
        if JSON.TryGetValue('enemy_slot_1_image', S) then
          FormMain.FrameTown.FrameOutlands1.Image2.Picture.Bitmap.Handle :=
            LoadBitmap(hInstance, PChar(S));
        if JSON.TryGetValue('enemy_slot_2_image', S) then
          FormMain.FrameTown.FrameOutlands1.Image3.Picture.Bitmap.Handle :=
            LoadBitmap(hInstance, PChar(S));
        if JSON.TryGetValue('enemy_slot_3_image', S) then
          FormMain.FrameTown.FrameOutlands1.Image4.Picture.Bitmap.Handle :=
            LoadBitmap(hInstance, PChar(S));
        FormMain.FrameTown.FrameOutlands1.BringToFront;
      end;
    end
    else
      FormMain.FrameTown.FrameDefault1.BringToFront;
    //
    if JSON.TryGetValue('mainframe', S) then
    begin
      if (S = 'outlands') then
      begin
        FormMain.FrameTown.FrameBattle1.BringToFront;
      end
      else if (S = 'shop_armor') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          DrawGrid;
          SG.Cells[1, 0] := 'Броня';
          for K := 1 to 6 do
            if JSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
        end;
    end
    else
      FormMain.FrameTown.FrameInfo1.BringToFront;
    //
    S := '';
    if JSON.TryGetValue('char_name', S) then
    begin
      bbCharName.Caption := S;
      FrameBattle1.Label4.Caption := S;
    end;
    if JSON.TryGetValue('char_level', V) then
    begin
      Panel11.Caption := 'Уровень: ' + V;
      FrameBattle1.Label7.Caption := 'Уровень: ' + V;
    end;
    if JSON.TryGetValue('char_exp', S) then
      Panel13.Caption := 'Опыт: ' + S + '/' + IntToStr(StrToIntDef(V, 1) * 100);
    if JSON.TryGetValue('char_food', S) then
    begin
      Panel15.Caption := 'Провизия: ' + S + '/7';
    end;
    if JSON.TryGetValue('char_gold', S) then
      Panel12.Caption := 'Золото: ' + S;
    if JSON.TryGetValue('char_life_cur', Cur) and
      JSON.TryGetValue('char_life_max', Max) then
    begin
      Panel1.Width := Round(Cur.ToInteger / Max.ToInteger * HPPanel.Width);
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
    if JSON.TryGetValue('char_equip_weapon_name', S) then
      pnEqWeapon.Caption := S;
    if JSON.TryGetValue('char_equip_armor_name', S) then
      pnEqArmor.Caption := S;
    //
    if JSON.TryGetValue('char_bank', S) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + S;
    //
    if JSON.TryGetValue('stat_kills', S) then
      FormMain.FrameTown.FrameChar.ttStatKills.Caption :=
        Format('Выиграно битв: %s', [S]);
    if JSON.TryGetValue('stat_deads', S) then
      FormMain.FrameTown.FrameChar.ttStatDeads.Caption :=
        Format('Поражений: %s', [S]);
    FormMain.FrameTown.FrameChar.ttWeapon.Caption := pnEqWeapon.Caption;
    FormMain.FrameTown.FrameChar.ttArmor.Caption := pnEqArmor.Caption;
    //
    S := '';
    if JSON.TryGetValue('enemy_name', S) then
      FormMain.FrameTown.FrameBattle1.lbEnemyName.Caption := S;
    if JSON.TryGetValue('enemy_level', V) then
      FormMain.FrameTown.FrameBattle1.Label8.Caption := 'Уровень: ' + V;
    if JSON.TryGetValue('enemy_life_cur', Cur) and
      JSON.TryGetValue('enemy_life_max', Max) then
      FormMain.FrameTown.FrameBattle1.Label2.Caption :=
        Format('Здоровье: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('enemy_damage_min', Cur) and
      JSON.TryGetValue('enemy_damage_max', Max) then
      FormMain.FrameTown.FrameBattle1.Label3.Caption :=
        Format('Урон: %s-%s', [Cur, Max]);
    if JSON.TryGetValue('enemy_image', S) then
      FormMain.FrameTown.FrameBattle1.Image2.Picture.Bitmap.Handle :=
        LoadBitmap(hInstance, PChar(S));
    LastCode := Code;
    FormMain.Refresh;
  finally
    JSON.Free;
  end;
end;

procedure TFrameTown.bbCharNameClick(Sender: TObject);
begin
  if IsCharMode then
    HideChar
  else
    ShowChar;
end;

procedure TFrameTown.bbChatClick(Sender: TObject);
begin
  if IsChatMode then
    HideChat
  else
    ShowChat;
end;

procedure TFrameTown.bbDebugClick(Sender: TObject);
begin
  FormInfo.ShowModal;
end;

end.
