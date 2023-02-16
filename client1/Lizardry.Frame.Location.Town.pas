unit Lizardry.Frame.Location.Town;

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
  Vcl.Buttons,
  Vcl.ExtCtrls,
  Lizardry.FrameBank,
  Lizardry.FrameDefault,
  Lizardry.FrameTavern,
  Lizardry.FrameOutlands,
  Lizardry.FrameBattle,
  Lizardry.FrameInfo,
  Lizardry.FrameLoot,
  Lizardry.FrameShop,
  Lizardry.FrameChar,
  Lizardry.FrameAfterBattle,
  Lizardry.FrameBeforeBattle,
  Lizardry.FrameGetLoot,
  Lizardry.FrameRandomPlace,
  Lizardry.FrameGetAllLoot;

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
    pnGold: TPanel;
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
    FrameAfterBattle1: TFrameAfterBattle;
    FrameBeforeBattle1: TFrameBeforeBattle;
    FrameGetLoot1: TFrameGetLoot;
    FrameRandomPlace1: TFrameRandomPlace;
    pnEffect: TPanel;
    FrameGetAllLoot1: TFrameGetAllLoot;
    Memo1: TMemo;
    procedure bbLogoutClick(Sender: TObject);
    procedure LeftPanelClick(Sender: TObject);
    procedure bbDebugClick(Sender: TObject);
    procedure bbCharNameClick(Sender: TObject);
    procedure FrameOutlands1Image1Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
  private
    { Private declarations }
    Title: string;
    procedure ClearButtons;
    procedure AddButton(const Title, Script: string);
    procedure ChLifePanels(const Cur, Max: string);
    procedure ChEnemyLifePanels(const Cur, Max: string);
    procedure ChManaPanels(const Cur, Max: string);
    procedure ChExpPanels(const Cur, Max: string);
    procedure ChFoodPanel(AFoodCount: string);
    procedure ChEffectPanel(S: string);
    procedure LoadPlayerImage;
  public
    { Public declarations }
    procedure ShowChar;
    procedure HideChar;
    procedure DoAction(S: string);
    procedure ParseJSON(AJSON: string); overload;
    procedure ParseJSON(AJSON, Section: string); overload;
    function IsActPanels: Boolean;
    function GetRaceName(const N: Byte): string;
    function GetRaceDescription(const N: Byte): string;
  end;

function GetLevelExp(const Level: Word): Integer;

var
  RegionLevel: Integer = 1;
  CurrentOutlands: string = '';

implementation

{$R *.dfm}

uses
  Math,
  JSON,
  IOUtils,
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.FormInfo,
  Lizardry.FormMsg,
  Lizardry.FormPrompt,
  Lizardry.Effects;

var
  LRaceIndex: Integer = 0;
  LGenderIndex: Integer = 0;

function StrLim(const S: string; const N: Integer = 25): string;
begin
  if Length(S) > N then
  begin
    Result := Trim(Copy(S, 1, N - 3)) + '...';
  end
  else
    Result := S;
end;

function GetLevelExp(const Level: Word): Integer;
begin
  Result := Level * ((Level - 1) + 100);
end;

function GetEffectName(const AEffectIdent: Byte): string;
var
  LJSON: string;
  LJSONArray: TJSONArray;
  I, LEffectCategory: Integer;

begin
  LJSON := FormInfo.EffMemo.Text;
  Result := '';
  LJSONArray := TJSONObject.ParseJSONValue(LJSON) as TJSONArray;
  for I := 0 to LJSONArray.Count - 1 do
  begin
    LEffectCategory :=
      StrToIntDef(TJSONPair(TJSONObject(LJSONArray.Get(I))
      .Get('effect_category')).JsonValue.Value, 0);
    Result := Trim(TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('effect_name'))
      .JsonValue.Value);
    if LEffectCategory = AEffectIdent then
      Exit;
  end;
end;

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
  LRaceDescription: array [0 .. 3] of string =
    ('Люди - жители Североземья. Испокон веков населяли эти земли. ' +
    'Со временем расселились по всему миру. Люди в меру высоки, достаточно ' +
    'стройны и сильны. У них нет особых преимуществ перед другими расами.',
    //
    'Эльфы - древние жители этого мира. Давным-давно они населяли леса ' +
    'всех континентов, но со временем их вытеснили другие расы. ' +
    'Теперь эльфы населяют только дремучие пралеса южных земель. ' +
    'Эльфы высоки, стройны и ловки. От других рас их отличают мудрость ' +
    'и превосходные познания в магических науках.',
    //
    'Гномы - коренные жители горных королевств востока и запада континента. ' +
    'Но сейчас их встречают в горах как северных, так и южных земель. ' +
    'Невысоки ростом, но коренасты и чрезвычайно сильны. Добывают минералы и ' +
    'руды, из них делают замечательные топоры, щиты и клинки. ' +
    'Из них получаются отличные воины и кузнецы.',
    //
    'Ящеры - болотные жители центральной экваториальной части континента. ' +
    'Внешне похожи на больших ящериц. Все тело покрыто тонкой чешуйчатой ' +
    'кожей. На голове бывают разные роговые наросты. Стройны. Высоки, но ' +
    'ниже эльфов ростом. Достаточно умны. Хорошо плавают и дышат под водой.' +
    'От других рас отличаются высокой ловкостью и изворотливостью.');
begin
  Result := LRaceDescription[N];
end;

procedure TFrameTown.ChEffectPanel(S: string);
var
  LJSON: TJSONObject;
  LJSONArray: TJSONArray;
  I, LCounter: Integer;
  LDiv, LEffectsStr: string;
begin
  Memo1.Clear;
  LEffectsStr := '';
  LCounter := 1;
  for I := 1 to 99 do
  begin
    LDiv := '';
    if LCounter > 1 then
      LDiv := ', ';
    if S.Contains('"id":"' + IntToStr(I) + '"') then
    begin
      LEffectsStr := LEffectsStr + LDiv + GetEffectName(I);
      Inc(LCounter);
    end;
  end;
  if LEffectsStr = '' then
    LEffectsStr := 'Нет';
  Memo1.Lines.Append(LEffectsStr);
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
  FormMain.FrameLogin.LoadLastEvents;
  FormMain.FrameLogin.BringToFront;
  ServerName := '';
  FormMain.UpdateCaption;
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
  if IsCharMode then
    bbCharNameClick(Sender);
  DoAction((Sender as TPanel).Script);
end;

procedure TFrameTown.LoadPlayerImage;
var
  LImagePath, LRace, LGender: string;
const
  Race: array [0 .. 3] of string = ('human', 'elf', 'gnome', 'lizard');
  Gender: array [0 .. 1] of string = ('male', 'female');
begin
  LRace := Race[LRaceIndex];
  LGender := Gender[LGenderIndex];
  LImagePath := TPath.GetHomePath + '\Lizardry\Images\player_' + LRace + '_' +
    LGender + '.jpg';
  FormMain.FrameTown.FrameBattle1.Image1.Picture.LoadFromFile(LImagePath);
  FormMain.FrameTown.FrameChar.imPortret.Picture.LoadFromFile(LImagePath);
end;

procedure TFrameTown.ParseJSON(AJSON, Section: string);
var
  LJSON: TJSONObject;
  LValue, LCurValue, LMaxValue: string;
  LSplitArray: TArray<string>;

  function Get(AKey: string; out AValue: string): Boolean;
  begin
    Result := Get(AKey, AValue);
  end;

begin
  if (Trim(AJSON) = '') then
    Exit;
  LJSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    if UpperCase(Section) = 'ERROR' then
    begin
      if Get('error', LValue) then
        ShowMsg('Ошибка: ' + LValue);
    end;
    if UpperCase(Section) = 'INFO' then
    begin
      if Get('info', LValue) then
        ShowMsg(LValue);
    end;
    if UpperCase(Section) = 'PROMPT' then
    begin
      if Get('prompt', LValue) then
        ShowMsg(LValue);
    end;
    if UpperCase(Section) = 'INV' then
    begin
      if Get('inventory', LValue) then
      begin
        FormMain.FrameTown.FrameChar.RefreshInventory(LValue);
        if Get('char_life_cur', LCurValue) and Get('char_life_max', LMaxValue)
        then
          ChLifePanels(LCurValue, LMaxValue);
        if Get('char_mana_cur', LCurValue) and Get('char_mana_max', LMaxValue)
        then
          ChManaPanels(LCurValue, LMaxValue);
        if Get('action', LValue) then
        begin
          LSplitArray := LValue.Split(['|']);
          Prompt(LSplitArray[0], LSplitArray[1], LSplitArray[2]);
        end;
        if Get('char_food', LValue) then
          ChFoodPanel(LValue);
        if Get('char_effects', LValue) then
          ChEffectPanel(LValue);
      end;
    end;
  finally
    LJSON.Free;
  end;
end;

procedure TFrameTown.ShowChar;
begin
  LoadPlayerImage;
  Title := Panel10.Caption;
  Panel10.Caption := bbCharName.Caption;
  FrameChar.ttInfo.Caption := '';
  FrameChar.PageControl1.ActivePageIndex := 1;
  FrameChar.SG.OnClick(Self);
  FrameChar.BringToFront;
  IsCharMode := True;
end;

procedure TFrameTown.SpeedButton3Click(Sender: TObject);
begin
  ShowMsg(Label1.Caption);
end;

procedure TFrameTown.bbCharNameClick(Sender: TObject);
begin
  if IsCharMode then
    HideChar
  else
    ShowChar;
end;

procedure TFrameTown.bbDebugClick(Sender: TObject);
begin
  FormInfo.PageControl1.ActivePageIndex := 0;
  FormInfo.ShowModal;
end;

procedure TFrameTown.ChEnemyLifePanels(const Cur, Max: string);
begin
  FormMain.FrameTown.FrameBattle1.ttEnemyLifeBar.Width :=
    Round(Cur.ToInteger / Max.ToInteger * HPPanel.Width);
end;

procedure TFrameTown.ChExpPanels(const Cur, Max: string);
begin
  Panel4.Width := Round(Cur.ToInteger / Max.ToInteger * XPPanel.Width);
  Panel13.Caption := Format('Опыт: %s/%s', [Cur, Max]);
end;

procedure TFrameTown.ChFoodPanel(AFoodCount: string);
begin
  Panel15.Caption := 'Провизия: ' + AFoodCount + '/7';
  FormMain.FrameTown.FrameOutlands1.Label1.Caption := AFoodCount + '/7';
end;

procedure TFrameTown.ChLifePanels(const Cur, Max: string);
begin
  Panel1.Width := Round(Cur.ToInteger / Max.ToInteger * HPPanel.Width);
  Panel14.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
  FrameBattle1.Panel5.Width :=
    Round(Cur.ToInteger / Max.ToInteger * HPPanel.Width);
  FrameBattle1.Label5.Caption := Format('Здоровье: %s/%s', [Cur, Max]);
end;

procedure TFrameTown.ChManaPanels(const Cur, Max: string);
begin
  Panel3.Width := Round(Cur.ToInteger / Max.ToInteger * MPPanel.Width);
  Panel16.Caption := Format('Мана: %s/%s', [Cur, Max]);
end;

procedure TFrameTown.ParseJSON(AJSON: string);
var
  LJSON: TJSONObject;
  LJSONArray: TJSONArray;
  LValue, LCurValue, LMaxValue, LDam, LDef: string;
  I, J, K, LGold, LFood: Integer;
  LSplitArray: TArray<string>;
  LFlag: Boolean;

  function Get(AKey: string; out AValue: string): Boolean;
  begin
    Result := LJSON.TryGetValue(AKey, AValue);
  end;

begin
  MsgBox(AJSON);
  if (Trim(AJSON) = '') then
    Exit;
  // Exit;
  if AJSON.Contains('{"inventory":') then
  begin
    InvJSON(AJSON);
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
  if AJSON.Contains('{"prompt":') then
  begin
    ParseJSON(AJSON, 'PROMPT');
    Exit;
  end;
  if AJSON.Contains('{"item":') then
  begin
    ParseJSON(AJSON, 'ITEM');
    Exit;
  end;
  LJSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    if Get('log', LValue) then
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText2.Caption := LValue
    end
    else if Get('user_message', LValue) then
    begin
      ShowMsg(LValue, 1000);
    end
    else
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText2.Caption := '';
    end;
    //
    if Get('battlelog', LValue) then
      with FrameBattle1 do
      begin
        BringToFront;
        DrawBattleLog(LValue);
      end;
    //
    if Get('title', LValue) then
      Panel10.Caption := LValue;
    if Get('description', LValue) then
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText1.Caption := LValue.Replace('#', #13#10);
      FrameShop1.Label1.Caption := LValue.Replace('#', #13#10);
    end;
    //
    ClearButtons;
    LJSONArray := TJSONArray(LJSON.Get('links').JsonValue);
    for I := 0 to LJSONArray.Size - 1 do
    begin
      AddButton(TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('title'))
        .JsonValue.Value, TJSONPair(TJSONObject(LJSONArray.Get(I)).Get('link'))
        .JsonValue.Value);
    end;
    //
    if Get('frame', LValue) then
    begin
      if (LValue = 'bank') then
      begin
        if Get('description', LValue) then
          FormMain.FrameTown.FrameInfo1.StaticText1.Caption :=
            LValue.Replace('#', #13#10);
        if Get('char_gold', LValue) then
        begin
          LGold := StrToIntDef(LValue, 0);
          FormMain.FrameTown.FrameBank1.GoldEdit.Text := IntToStr(LGold);
          FormMain.FrameTown.FrameBank1.bbMyGold.Caption := IntToStr(LGold);
        end;
        FormMain.FrameTown.FrameBank1.BringToFront;
      end
      else if (LValue = 'campfire') then
      begin
        if Get('current_outlands', LValue) then
        begin
          CurrentOutlands := LValue;
          FormMain.FrameTown.FrameLoot1.BringToFront;
        end;
      end
      else if (LValue = 'get_loot') then
      begin
        if Get('current_outlands', LValue) then
        begin
          CurrentOutlands := LValue;
          FormMain.FrameTown.FrameGetLoot1.BringToFront;
        end;
      end
      else if (LValue = 'get_random_place') then
      begin
        FormMain.FrameTown.FrameRandomPlace1.BringToFront;
      end
      else if (LValue = 'before_battle') then
      begin
        if Get('current_outlands', LValue) then
        begin
          CurrentOutlands := LValue;
          FormMain.FrameTown.FrameBeforeBattle1.BringToFront;
        end;
      end
      else if (LValue = 'battle') then
      begin
        if Get('current_outlands', LValue) then
        begin
          CurrentOutlands := LValue;
          FormMain.FrameTown.FrameAfterBattle1.BringToFront;
        end;
      end
      else if (LValue = 'tavern') then
      begin
        if Get('char_food', LValue) then
        begin
          LFood := StrToIntDef(LValue, 0);
          LFood := EnsureRange(7 - LFood, 0, 7);
          FormMain.FrameTown.FrameTavern1.Edit1.Text := IntToStr(LFood);
        end;
        FormMain.FrameTown.FrameTavern1.BringToFront;
      end
      else if (LValue = 'outlands') then
      begin
        if Get('enemy_slot_1_image', LValue) then
          if ((LValue <> '') and FileExists(FormInfo.ImagesPath.Caption + LValue
            + '.jpg')) then
          begin
            FormMain.FrameTown.FrameOutlands1.Image2.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + LValue + '.jpg');
            if Get('enemy_slot_1_level', LValue) and (LValue <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label2.Caption := LValue;
              FormMain.FrameTown.FrameOutlands1.Image2.Visible :=
                (LValue <> '0');
              FormMain.FrameTown.FrameOutlands1.Label2.Visible :=
                (LValue <> '0');
              LFlag := False;
              if Get('enemy_slot_1_elite', LValue) and (LValue <> '') then
              begin
                LFlag := (LValue <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image5.Visible :=
                (LValue <> '0') and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image6.Visible :=
                (LValue <> '0') and LFlag;
            end;
          end;
        if Get('enemy_slot_2_image', LValue) then
          if ((LValue <> '') and FileExists(FormInfo.ImagesPath.Caption + LValue
            + '.jpg')) then
          begin
            FormMain.FrameTown.FrameOutlands1.Image3.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + LValue + '.jpg');
            if Get('enemy_slot_2_level', LValue) and (LValue <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label3.Caption := LValue;
              FormMain.FrameTown.FrameOutlands1.Image3.Visible :=
                (LValue <> '0');
              FormMain.FrameTown.FrameOutlands1.Label3.Visible :=
                (LValue <> '0');
              LFlag := False;
              if Get('enemy_slot_2_elite', LValue) and (LValue <> '') then
              begin
                LFlag := (LValue <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image7.Visible :=
                (LValue <> '0') and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image9.Visible :=
                (LValue <> '0') and LFlag;
            end;
          end;
        if Get('enemy_slot_3_image', LValue) then
          if ((LValue <> '') and FileExists(FormInfo.ImagesPath.Caption + LValue
            + '.jpg')) then
          begin
            FormMain.FrameTown.FrameOutlands1.Image4.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + LValue + '.jpg');
            if Get('enemy_slot_3_level', LValue) and (LValue <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label4.Caption := LValue;
              FormMain.FrameTown.FrameOutlands1.Image4.Visible :=
                (LValue <> '0');
              FormMain.FrameTown.FrameOutlands1.Label4.Visible :=
                (LValue <> '0');
              LFlag := False;
              if Get('enemy_slot_3_elite', LValue) and (LValue <> '') then
              begin
                LFlag := (LValue <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image8.Visible :=
                (LValue <> '0') and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image10.Visible :=
                (LValue <> '0') and LFlag;
            end;
          end;
        FormMain.FrameTown.FrameOutlands1.BringToFront;
      end;
    end
    else
      FormMain.FrameTown.FrameDefault1.BringToFront;
    //
    if Get('mainframe', LValue) then
    begin
      if (LValue = 'outlands') then
      begin
        LoadPlayerImage;
        FormMain.FrameTown.FrameBattle1.BringToFront;
      end
      else if (LValue = 'shop_weapon') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stWeapon;
          DrawGrid;
          SG.Cells[1, 0] := 'Оружие';
          SG.Cells[2, 0] := 'Урон';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (LValue = 'shop_armor') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stArmor;
          DrawGrid;
          SG.Cells[1, 0] := 'Доспех';
          SG.Cells[2, 0] := 'Броня';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (LValue = 'shop_alchemy') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stAlchemy;
          DrawGrid;
          SG.Cells[1, 0] := 'Эликсир';
          SG.Cells[2, 0] := 'Мощь';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (LValue = 'shop_magic') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stMagic;
          DrawGrid;
          SG.Cells[1, 0] := 'Свиток';
          SG.Cells[2, 0] := 'Мощь';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (LValue = 'tavern') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stTavern;
          DrawGrid;
          SG.Cells[1, 0] := 'Предмет';
          SG.Cells[2, 0] := 'Значение';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (LValue = 'black_market') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stTavern;
          DrawGrid;
          SG.Cells[1, 0] := 'Предмет';
          SG.Cells[2, 0] := 'Значение';
          for K := 1 to 6 do
            if Get('item_slot_' + IntToStr(K) + '_values', LValue) then
            begin
              LSplitArray := LValue.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := LSplitArray[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end;
    end
    else
      FormMain.FrameTown.FrameInfo1.BringToFront;
    //
    LValue := '';
    if Get('char_name', LValue) then
    begin
      bbCharName.Caption := LValue;
      FrameBattle1.Label4.Caption := LValue;
    end;
    if Get('char_gender', LValue) then
      LGenderIndex := StrToIntDef(LValue, 0);
    if Get('char_race', LValue) then
    begin
      LRaceIndex := StrToIntDef(LValue, 0);
      Panel2.Caption := 'Раса: ' + GetRaceName(LRaceIndex);
      Label1.Caption := GetRaceDescription(StrToIntDef(LValue, 0));
    end;
    if Get('char_region_level', LValue) then
      RegionLevel := StrToIntDef(LValue, 1);
    if Get('char_level', LValue) then
    begin
      Panel11.Caption := 'Уровень: ' + LValue;
      FrameBattle1.Label7.Caption := 'Уровень: ' + LValue;
    end;
    if Get('char_exp', LCurValue) then
      ChExpPanels(LCurValue, IntToStr(GetLevelExp(StrToIntDef(LValue, 1))));
    if Get('char_food', LValue) then
      ChFoodPanel(LValue);
    if Get('char_gold', LValue) then
    begin
      pnGold.Caption := 'Золото: ' + LValue;
      if Get('char_bank', LValue) then
        pnGold.Hint := 'Золото в банке: ' + LValue;

    end;
    if Get('char_life_cur', LCurValue) and Get('char_life_max', LMaxValue) then
      ChLifePanels(LCurValue, LMaxValue);
    if Get('char_mana_cur', LCurValue) and Get('char_mana_max', LMaxValue) then
      ChManaPanels(LCurValue, LMaxValue);
    if Get('char_damage_min', LCurValue) and Get('char_damage_max', LMaxValue)
    then
    begin
      LDam := Format('Урон: %s-%s', [LCurValue, LMaxValue]);
      Panel17.Caption := LDam;
      FrameBattle1.ttCharDamage.Caption :=
        Format('Урон: %s-%s', [LCurValue, LMaxValue]);
    end;
    if Get('char_armor', LValue) then
    begin
      LDef := Format('Броня: %s', [LValue]);
      Panel18.Caption := LDef;
      FrameBattle1.ttCharArmor.Caption := 'Броня: ' + LValue;
    end;
    //
    if Get('char_equip_weapon_name', LValue) then
    begin
      pnEqWeapon.Caption := StrLim(LValue);
      pnEqWeapon.Hint := Format('%s (%s)', [LValue, LDam]);
    end;
    if Get('char_equip_armor_name', LValue) then
    begin
      pnEqArmor.Caption := StrLim(LValue);
      pnEqArmor.Hint := Format('%s (%s)', [LValue, LDef]);
    end;
    //
    if Get('char_bank', LValue) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + LValue;
    //
    if Get('char_effects', LValue) then
      ChEffectPanel(LValue);
    //
    if Get('char_inventory', LValue) then
      FormMain.FrameTown.FrameChar.RefreshInventory(LValue);
    //
    if Get('stat_kills', LValue) then
      FormMain.FrameTown.FrameChar.ttStatKills.Caption :=
        Format('Выиграно битв: %s', [LValue]);
    if Get('stat_deads', LValue) then
      FormMain.FrameTown.FrameChar.ttStatDeads.Caption :=
        Format('Поражений: %s', [LValue]);
    if Get('stat_boss_kills', LValue) then
      FormMain.FrameTown.FrameChar.ttStatBossKills.Caption :=
        Format('Повержено боссов: %s', [LValue]);

    FormMain.FrameTown.FrameChar.ttWeapon.Caption := pnEqWeapon.Hint;
    FormMain.FrameTown.FrameChar.ttArmor.Caption := pnEqArmor.Hint;
    //
    LValue := '';
    if Get('enemy_name', LValue) then
      FormMain.FrameTown.FrameBattle1.ttEnemyName.Caption := LValue;
    if Get('enemy_level', LValue) then
      FormMain.FrameTown.FrameBattle1.ttEnemyLevel.Caption :=
        'Уровень: ' + LValue;
    if Get('enemy_life_cur', LCurValue) and Get('enemy_life_max', LMaxValue)
    then
    begin
      FormMain.FrameTown.FrameBattle1.ttEnemyLife.Caption :=
        Format('Здоровье: %s/%s', [LCurValue, LMaxValue]);
      ChEnemyLifePanels(LCurValue, LMaxValue);
    end;
    if Get('enemy_damage_min', LCurValue) and Get('enemy_damage_max', LMaxValue)
    then
      FormMain.FrameTown.FrameBattle1.ttEnemyDamage.Caption :=
        Format('Урон: %s-%s', [LCurValue, LMaxValue]);
    if Get('enemy_armor', LValue) then
      FormMain.FrameTown.FrameBattle1.ttEnemyArmor.Caption := 'Броня: '
        + LValue;
    if Get('enemy_image', LValue) then
      if ((LValue <> '') and FileExists(FormInfo.ImagesPath.Caption + LValue +
        '.jpg')) then
        FormMain.FrameTown.FrameBattle1.Image2.Picture.LoadFromFile
          (FormInfo.ImagesPath.Caption + LValue + '.jpg');
    FormMain.Refresh;
  finally
    LJSON.Free;
  end;
end;

end.
