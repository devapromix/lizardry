unit Lizardry.Frame.Location.Town;

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
    MPPanel: TPanel;
    Panel3: TPanel;
    XPPanel: TPanel;
    Panel4: TPanel;
    Panel2: TPanel;
    SpeedButton3: TSpeedButton;
    Label1: TLabel;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
    procedure bbDebugClick(Sender: TObject);
    procedure bbChatClick(Sender: TObject);
    procedure bbCharNameClick(Sender: TObject);
    procedure FrameOutlands1Image1Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
  private
    { Private declarations }
    Title: string;
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
    procedure ChLifePanels(const Cur, Max: string);
    procedure ChManaPanels(const Cur, Max: string);
    procedure ChExpPanels(const Cur, Max: string);
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
    function GetRaceName(const N: Byte): string;
    function GetRaceDescription(const N: Byte): string;
  end;

var
  RegionLevel: Integer = 1;
  CurrentOutlands: string = '';

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

procedure TFrameTown.FrameOutlands1Image1Click(Sender: TObject);
begin
  FrameOutlands1.Image1Click(Sender);

end;

function TFrameTown.GetRaceDescription(const N: Byte): string;
const
  RaceName: array [0 .. 3] of string =
    ('Люди - жители Североземья. Испокон веков населяли эти земли. ' +
    'Со временем расселились по всему миру. Люди в меру высоки, достаточно ' +
    'стройны и сильны. У них нет особых преимуществ перед другими расами.',
    'Эльфы - древние жители этого мира. Давным-давно они населяли леса ' +
    'всех континентов, но со временем их вытеснили другие расы. ' +
    'Теперь эльфы населяют только дремучие пралеса южных земель. ' +
    'Эльфы высоки, стройны и ловки. От других рас их отличают мудрость ' +
    'и превосходные познания в магических науках.',
    'Гномы - коренные жители горных королевств востока и запада континента. ' +
    'Но сейчас их встречают в горах как северных, так и южных земель. ' +
    'Невысоки ростом, но коренасты и чрезвычайно сильны. Добывают минералы и ' +
    'руды, из них делают замечательные топоры, щиты и клинки и занимаются ' +
    'торговлей по всему миру. Из них получаются отличные воины и кузнецы.',
    'Ящеры - болотные жители центральной экваториальной части континента. ' +
    'Внешне похожи на большых ящериц. Все тело покрыто тонкой чешуйчатой ' +
    'кожей. На голове бывают разные роговые наросты. ' +
    'Стройны. Заметно выше людей, но ниже эльфов ростом. Достаточно умны. ' +
    'Хорошо плавают и умеют дышать под водой.' +
    'От других рас отличаются высокой ловкостью и изворотливостью.');
begin
  Result := RaceName[N];
end;

function TFrameTown.GetRaceName(const N: Byte): string;
const
  RaceName: array [0 .. 3] of string = ('Человек', 'Эльф', 'Гном', 'Ящер');
begin
  Result := RaceName[N];
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
  if IsChatMode then
    bbChatClick(Sender);
  if IsCharMode then
    bbCharNameClick(Sender);
  DoAction((Sender as TPanel).Script);
end;

procedure TFrameTown.ParseJSON(AJSON, Section: string);
var
  JSON: TJSONObject;
  S, Cur, Max: string;
begin
  JSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    if UpperCase(Section) = 'ITEM' then
    begin
      if JSON.TryGetValue('item', S) then
      begin
        FormMain.FrameTown.FrameChar.ttInfo.Caption := S;
        FormMain.FrameTown.FrameShop1.ttInfo.Caption := S;
      end;
    end;
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
    if UpperCase(Section) = 'INV' then
    begin
      if JSON.TryGetValue('inventory', S) then
      begin
        FormMain.FrameTown.FrameChar.RefreshInventory(S);
        if JSON.TryGetValue('char_life_cur', Cur) and
          JSON.TryGetValue('char_life_max', Max) then
          ChLifePanels(Cur, Max);
        if JSON.TryGetValue('char_mana_cur', Cur) and
          JSON.TryGetValue('char_mana_max', Max) then
          ChManaPanels(Cur, Max);
      end;
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
  FrameChar.ttInfo.Caption := '';
  FrameChar.PageControl1.ActivePageIndex := 1;
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

procedure TFrameTown.SpeedButton3Click(Sender: TObject);
begin
  ShowMsg(Label1.Caption);
end;

procedure TFrameTown.ChExpPanels(const Cur, Max: string);
begin
  Panel4.Width := Round(Cur.ToInteger / Max.ToInteger * XPPanel.Width);
  Panel13.Caption := Format('Опыт: %s/%s', [Cur, Max]);
end;

procedure TFrameTown.ChLifePanels(const Cur, Max: string);
begin
  Panel1.Width := Round(Cur.ToInteger / Max.ToInteger * HPPanel.Width);
  Panel14.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
  FrameBattle1.Label5.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
end;

procedure TFrameTown.ChManaPanels(const Cur, Max: string);
begin
  Panel3.Width := Round(Cur.ToInteger / Max.ToInteger * MPPanel.Width);
  Panel16.Caption := Format('Мана: %s/%s', [Cur, Max]);
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
  if AJSON.Contains('{"inventory":') then
  begin
    InvError(AJSON);
    ParseJSON(AJSON, 'INV');
    Exit;
  end;
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
  if AJSON.Contains('{"item":') then
  begin
    ParseJSON(AJSON, 'ITEM');
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
        DrawBattleLog(S);
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
        FormMain.FrameTown.FrameBank1.Welcome;
        if JSON.TryGetValue('char_gold', S) then
        begin
          F := StrToIntDef(S, 0);
          FormMain.FrameTown.FrameBank1.GoldEdit.Text := IntToStr(F);
          FormMain.FrameTown.FrameBank1.bbMyGold.Caption := IntToStr(F);
        end;
        FormMain.FrameTown.FrameBank1.BringToFront;
      end
      else if (S = 'campfire') then
      begin
        if JSON.TryGetValue('current_outlands', S) then
        begin
          CurrentOutlands := S;
          FormMain.FrameTown.FrameLoot1.BringToFront;
        end;
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
          if ((S <> '') and FileExists(FormInfo.MobImagesPath.Caption + S +
            '.jpg')) then
            FormMain.FrameTown.FrameOutlands1.Image2.Picture.LoadFromFile
              (FormInfo.MobImagesPath.Caption + S + '.jpg');
        if JSON.TryGetValue('enemy_slot_2_image', S) then
          if ((S <> '') and FileExists(FormInfo.MobImagesPath.Caption + S +
            '.jpg')) then
            FormMain.FrameTown.FrameOutlands1.Image3.Picture.LoadFromFile
              (FormInfo.MobImagesPath.Caption + S + '.jpg');
        if JSON.TryGetValue('enemy_slot_3_image', S) then
          if ((S <> '') and FileExists(FormInfo.MobImagesPath.Caption + S +
            '.jpg')) then
            FormMain.FrameTown.FrameOutlands1.Image4.Picture.LoadFromFile
              (FormInfo.MobImagesPath.Caption + S + '.jpg');
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
      else if (S = 'shop_weapon') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          DrawGrid;
          Welcome;
          ShopType := stWeapon;
          SG.Cells[1, 0] := 'Оружие';
          SG.Cells[2, 0] := 'Урон';
          for K := 1 to 6 do
            if JSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
        end
      else if (S = 'shop_armor') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          DrawGrid;
          Welcome;
          ShopType := stArmor;
          SG.Cells[1, 0] := 'Доспех';
          SG.Cells[2, 0] := 'Броня';
          for K := 1 to 6 do
            if JSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
        end
      else if (S = 'shop_alchemy') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          DrawGrid;
          Welcome;
          ShopType := stAlchemy;
          SG.Cells[1, 0] := 'Эликсир';
          SG.Cells[2, 0] := 'Мощь';
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
    if JSON.TryGetValue('char_race', S) then
    begin
      Panel2.Caption := 'Раса: ' + GetRaceName(StrToIntDef(S, 0));
      Label1.Caption := GetRaceDescription(StrToIntDef(S, 0));
    end;
    if JSON.TryGetValue('char_region_level', S) then
      RegionLevel := StrToIntDef(S, 1);
    if JSON.TryGetValue('char_level', V) then
    begin
      Panel11.Caption := 'Уровень: ' + V;
      FrameBattle1.Label7.Caption := 'Уровень: ' + V;
    end;
    if JSON.TryGetValue('char_exp', Cur) then
    begin
      ChExpPanels(Cur, IntToStr(StrToIntDef(V, 1) * 100));
    end;
    if JSON.TryGetValue('char_food', S) then
    begin
      Panel15.Caption := 'Провизия: ' + S + '/7';
    end;
    if JSON.TryGetValue('char_gold', S) then
      Panel12.Caption := 'Золото: ' + S;
    if JSON.TryGetValue('char_life_cur', Cur) and
      JSON.TryGetValue('char_life_max', Max) then
      ChLifePanels(Cur, Max);
    if JSON.TryGetValue('char_mana_cur', Cur) and
      JSON.TryGetValue('char_mana_max', Max) then
      ChManaPanels(Cur, Max);
    if JSON.TryGetValue('char_damage_min', Cur) and
      JSON.TryGetValue('char_damage_max', Max) then
    begin
      Panel17.Caption := Format('Урон: %s-%s', [Cur, Max]);
      FrameBattle1.ttCharDamage.Caption := Format('Урон: %s-%s', [Cur, Max]);
    end;
    if JSON.TryGetValue('char_armor', S) then
    begin
      Panel18.Caption := 'Броня: ' + S;
      FrameBattle1.ttCharArmor.Caption := 'Броня: ' + S;
    end;
    //
    if JSON.TryGetValue('char_equip_weapon_name', S) then
      pnEqWeapon.Caption := S;
    if JSON.TryGetValue('char_equip_armor_name', S) then
      pnEqArmor.Caption := S;
    //
    if JSON.TryGetValue('char_bank', S) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + S;
    //
    if JSON.TryGetValue('char_inventory', S) then
      FormMain.FrameTown.FrameChar.RefreshInventory(S);
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
      FormMain.FrameTown.FrameBattle1.ttEnemyName.Caption := S;
    if JSON.TryGetValue('enemy_level', V) then
      FormMain.FrameTown.FrameBattle1.ttEnemyLevel.Caption := 'Уровень: ' + V;
    if JSON.TryGetValue('enemy_life_cur', Cur) and
      JSON.TryGetValue('enemy_life_max', Max) then
      FormMain.FrameTown.FrameBattle1.ttEnemyLife.Caption :=
        Format('Здоровье: %s/%s', [Cur, Max]);
    if JSON.TryGetValue('enemy_damage_min', Cur) and
      JSON.TryGetValue('enemy_damage_max', Max) then
      FormMain.FrameTown.FrameBattle1.ttEnemyDamage.Caption :=
        Format('Урон: %s-%s', [Cur, Max]);
    if JSON.TryGetValue('enemy_armor', V) then
      FormMain.FrameTown.FrameBattle1.ttEnemyArmor.Caption := 'Броня: ' + V;
    if JSON.TryGetValue('enemy_image', S) then
      if ((S <> '') and FileExists(FormInfo.MobImagesPath.Caption + S + '.jpg'))
      then
        FormMain.FrameTown.FrameBattle1.Image2.Picture.LoadFromFile
          (FormInfo.MobImagesPath.Caption + S + '.jpg');
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
