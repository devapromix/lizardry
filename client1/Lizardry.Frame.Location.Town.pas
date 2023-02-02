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
  Lizardry.FrameRandomPlace, Lizardry.FrameGetAllLoot;

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
    procedure ChFoodPanel(S: string);
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
  IOUtils,
  JSON,
  Lizardry.FormMain,
  Lizardry.Server,
  Lizardry.FormInfo,
  Lizardry.FormMsg,
  Lizardry.FormPrompt,
  Lizardry.Effects;

var
  LastCode: string = '';
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
  RaceDescription: array [0 .. 3] of string =
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
  Result := RaceDescription[N];
end;

procedure TFrameTown.ChEffectPanel(S: string);
var
  LJSON: TJSONObject;
  LJSONArray: TJSONArray;
  I, J, C: Integer;
  D, K: string;
begin
  Memo1.Clear;
  K := '';
  C := 1;
  for I := 1 to 99 do
  begin
    D := '';
    if C > 1 then
      D := ', ';
    if S.Contains('"id":"' + IntToStr(I) + '"') then
    begin
      K := K + D + GetEffectName(I);
      Inc(C);
    end;
  end;
  if K = '' then
    K := 'Нет';
  Memo1.Lines.Append(K);
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
  S, Cur, Max: string;
  R: TArray<string>;
begin
  if (Trim(AJSON) = '') then
    Exit;
  LJSON := TJSONObject.ParseJSONValue(AJSON, False) as TJSONObject;
  try
    { if UpperCase(Section) = 'ITEM' then
      begin
      if LJSON.TryGetValue('item', S) then
      begin
      FormMain.FrameTown.FrameChar.ttInfo.Caption := S;
      FormMain.FrameTown.FrameShop1.ttInfo.Caption := S;
      end;
      end; }
    if UpperCase(Section) = 'ERROR' then
    begin
      if LJSON.TryGetValue('error', S) then
        ShowMsg('Ошибка: ' + S);
    end;
    if UpperCase(Section) = 'INFO' then
    begin
      if LJSON.TryGetValue('info', S) then
        ShowMsg(S);
    end;
    if UpperCase(Section) = 'PROMPT' then
    begin
      if LJSON.TryGetValue('prompt', S) then
        ShowMsg(S);
    end;
    if UpperCase(Section) = 'INV' then
    begin
      if LJSON.TryGetValue('inventory', S) then
      begin
        FormMain.FrameTown.FrameChar.RefreshInventory(S);
        if LJSON.TryGetValue('char_life_cur', Cur) and
          LJSON.TryGetValue('char_life_max', Max) then
          ChLifePanels(Cur, Max);
        if LJSON.TryGetValue('char_mana_cur', Cur) and
          LJSON.TryGetValue('char_mana_max', Max) then
          ChManaPanels(Cur, Max);
        if LJSON.TryGetValue('action', S) then
        begin
          R := S.Split(['|']);
          Prompt(R[0], R[1], R[2]);
        end;
        if LJSON.TryGetValue('char_food', S) then
          ChFoodPanel(S);
        if LJSON.TryGetValue('char_effects', S) then
          ChEffectPanel(S);
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

procedure TFrameTown.ChFoodPanel(S: string);
begin
  Panel15.Caption := 'Провизия: ' + S + '/7';
  FormMain.FrameTown.FrameOutlands1.Label1.Caption := S + '/7';
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
  S, V, Cur, Max, Code, LDam, LDef: string;
  I, F, J, K: Integer;
  A: TArray<string>;
  LFlag: Boolean;
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
    if LJSON.TryGetValue('log', S) then
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
    if LJSON.TryGetValue('battlelog', S) then
      with FrameBattle1 do
      begin
        BringToFront;
        DrawBattleLog(S);
      end;
    //
    if LJSON.TryGetValue('title', S) then
      Panel10.Caption := S;
    if LJSON.TryGetValue('description', S) then
    begin
      FrameInfo1.BringToFront;
      FrameInfo1.StaticText1.Caption := S.Replace('#', #13#10);
      FrameShop1.Label1.Caption := S.Replace('#', #13#10);
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
    if LJSON.TryGetValue('frame', S) then
    begin
      if (S = 'bank') then
      begin
        if LJSON.TryGetValue('description', S) then
          FormMain.FrameTown.FrameInfo1.StaticText1.Caption :=
            S.Replace('#', #13#10);
        if LJSON.TryGetValue('char_gold', S) then
        begin
          F := StrToIntDef(S, 0);
          FormMain.FrameTown.FrameBank1.GoldEdit.Text := IntToStr(F);
          FormMain.FrameTown.FrameBank1.bbMyGold.Caption := IntToStr(F);
        end;
        FormMain.FrameTown.FrameBank1.BringToFront;
      end
      else if (S = 'campfire') then
      begin
        if LJSON.TryGetValue('current_outlands', S) then
        begin
          CurrentOutlands := S;
          FormMain.FrameTown.FrameLoot1.BringToFront;
        end;
      end
      else if (S = 'get_loot') then
      begin
        if LJSON.TryGetValue('current_outlands', S) then
        begin
          CurrentOutlands := S;
          FormMain.FrameTown.FrameGetLoot1.BringToFront;
        end;
      end
      else if (S = 'get_random_place') then
      begin
        FormMain.FrameTown.FrameRandomPlace1.BringToFront;
      end
      else if (S = 'before_battle') then
      begin
        if LJSON.TryGetValue('current_outlands', S) then
        begin
          CurrentOutlands := S;
          FormMain.FrameTown.FrameBeforeBattle1.BringToFront;
        end;
      end
      else if (S = 'battle') then
      begin
        if LJSON.TryGetValue('current_outlands', S) then
        begin
          CurrentOutlands := S;
          FormMain.FrameTown.FrameAfterBattle1.BringToFront;
        end;
      end
      else if (S = 'tavern') then
      begin
        if LJSON.TryGetValue('char_food', S) then
        begin
          F := StrToIntDef(S, 0);
          F := EnsureRange(7 - F, 0, 7);
          FormMain.FrameTown.FrameTavern1.Edit1.Text := IntToStr(F);
        end;
        FormMain.FrameTown.FrameTavern1.BringToFront;
      end
      else if (S = 'outlands') then
      begin
        if LJSON.TryGetValue('enemy_slot_1_image', S) then
          if ((S <> '') and FileExists(FormInfo.ImagesPath.Caption + S + '.jpg'))
          then
          begin
            FormMain.FrameTown.FrameOutlands1.Image2.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + S + '.jpg');
            if LJSON.TryGetValue('enemy_slot_1_level', S) and (S <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label2.Caption := S;
              FormMain.FrameTown.FrameOutlands1.Image2.Visible := (S <> '0');
              FormMain.FrameTown.FrameOutlands1.Label2.Visible := (S <> '0');
              LFlag := False;
              if LJSON.TryGetValue('enemy_slot_1_elite', S) and (S <> '') then
              begin
                LFlag := (S <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image5.Visible := (S <> '0')
                and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image6.Visible := (S <> '0')
                and LFlag;
            end;
          end;
        if LJSON.TryGetValue('enemy_slot_2_image', S) then
          if ((S <> '') and FileExists(FormInfo.ImagesPath.Caption + S + '.jpg'))
          then
          begin
            FormMain.FrameTown.FrameOutlands1.Image3.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + S + '.jpg');
            if LJSON.TryGetValue('enemy_slot_2_level', S) and (S <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label3.Caption := S;
              FormMain.FrameTown.FrameOutlands1.Image3.Visible := (S <> '0');
              FormMain.FrameTown.FrameOutlands1.Label3.Visible := (S <> '0');
              LFlag := False;
              if LJSON.TryGetValue('enemy_slot_2_elite', S) and (S <> '') then
              begin
                LFlag := (S <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image7.Visible := (S <> '0')
                and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image9.Visible := (S <> '0')
                and LFlag;
            end;
          end;
        if LJSON.TryGetValue('enemy_slot_3_image', S) then
          if ((S <> '') and FileExists(FormInfo.ImagesPath.Caption + S + '.jpg'))
          then
          begin
            FormMain.FrameTown.FrameOutlands1.Image4.Picture.LoadFromFile
              (FormInfo.ImagesPath.Caption + S + '.jpg');
            if LJSON.TryGetValue('enemy_slot_3_level', S) and (S <> '') then
            begin
              FormMain.FrameTown.FrameOutlands1.Label4.Caption := S;
              FormMain.FrameTown.FrameOutlands1.Image4.Visible := (S <> '0');
              FormMain.FrameTown.FrameOutlands1.Label4.Visible := (S <> '0');
              LFlag := False;
              if LJSON.TryGetValue('enemy_slot_3_elite', S) and (S <> '') then
              begin
                LFlag := (S <> '0');
              end;
              FormMain.FrameTown.FrameOutlands1.Image8.Visible := (S <> '0')
                and LFlag;
              FormMain.FrameTown.FrameOutlands1.Image10.Visible := (S <> '0')
                and LFlag;
            end;
          end;
        FormMain.FrameTown.FrameOutlands1.BringToFront;
      end;
    end
    else
      FormMain.FrameTown.FrameDefault1.BringToFront;
    //
    if LJSON.TryGetValue('mainframe', S) then
    begin
      if (S = 'outlands') then
      begin
        LoadPlayerImage;
        FormMain.FrameTown.FrameBattle1.BringToFront;
      end
      else if (S = 'shop_weapon') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stWeapon;
          DrawGrid;
          SG.Cells[1, 0] := 'Оружие';
          SG.Cells[2, 0] := 'Урон';
          for K := 1 to 6 do
            if LJSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (S = 'shop_armor') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stArmor;
          DrawGrid;
          SG.Cells[1, 0] := 'Доспех';
          SG.Cells[2, 0] := 'Броня';
          for K := 1 to 6 do
            if LJSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (S = 'shop_alchemy') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stAlchemy;
          DrawGrid;
          SG.Cells[1, 0] := 'Эликсир';
          SG.Cells[2, 0] := 'Мощь';
          for K := 1 to 6 do
            if LJSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (S = 'shop_magic') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stMagic;
          DrawGrid;
          SG.Cells[1, 0] := 'Свиток';
          SG.Cells[2, 0] := 'Мощь';
          for K := 1 to 6 do
            if LJSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end
      else if (S = 'tavern') then
        with FormMain.FrameTown.FrameShop1 do
        begin
          ShopType := stTavern;
          DrawGrid;
          SG.Cells[1, 0] := 'Предмет';
          SG.Cells[2, 0] := 'Значение';
          for K := 1 to 6 do
            if LJSON.TryGetValue('item_slot_' + IntToStr(K) + '_values', S) then
            begin
              A := S.Split([',']);
              for J := 0 to 3 do
                SG.Cells[J + 1, K] := A[J];
            end;
          BringToFront;
          SG.SetFocus;
          SG.OnClick(Self);
        end;
    end
    else
      FormMain.FrameTown.FrameInfo1.BringToFront;
    //
    S := '';
    if LJSON.TryGetValue('char_name', S) then
    begin
      bbCharName.Caption := S;
      FrameBattle1.Label4.Caption := S;
    end;
    if LJSON.TryGetValue('char_gender', S) then
      LGenderIndex := StrToIntDef(S, 0);
    if LJSON.TryGetValue('char_race', S) then
    begin
      LRaceIndex := StrToIntDef(S, 0);
      Panel2.Caption := 'Раса: ' + GetRaceName(LRaceIndex);
      Label1.Caption := GetRaceDescription(StrToIntDef(S, 0));
    end;
    if LJSON.TryGetValue('char_region_level', S) then
      RegionLevel := StrToIntDef(S, 1);
    if LJSON.TryGetValue('char_level', V) then
    begin
      Panel11.Caption := 'Уровень: ' + V;
      FrameBattle1.Label7.Caption := 'Уровень: ' + V;
    end;
    if LJSON.TryGetValue('char_exp', Cur) then
    begin
      ChExpPanels(Cur, IntToStr(GetLevelExp(StrToIntDef(V, 1))));
    end;
    if LJSON.TryGetValue('char_food', S) then
      ChFoodPanel(S);
    if LJSON.TryGetValue('char_gold', S) then
    begin
      pnGold.Caption := 'Золото: ' + S;
      if LJSON.TryGetValue('char_bank', S) then
        pnGold.Hint := 'Золото в банке: ' + S;

    end;
    if LJSON.TryGetValue('char_life_cur', Cur) and
      LJSON.TryGetValue('char_life_max', Max) then
      ChLifePanels(Cur, Max);
    if LJSON.TryGetValue('char_mana_cur', Cur) and
      LJSON.TryGetValue('char_mana_max', Max) then
      ChManaPanels(Cur, Max);
    if LJSON.TryGetValue('char_damage_min', Cur) and
      LJSON.TryGetValue('char_damage_max', Max) then
    begin
      LDam := Format('Урон: %s-%s', [Cur, Max]);
      Panel17.Caption := LDam;
      FrameBattle1.ttCharDamage.Caption := Format('Урон: %s-%s', [Cur, Max]);
    end;
    if LJSON.TryGetValue('char_armor', S) then
    begin
      LDef := Format('Броня: %s', [S]);
      Panel18.Caption := LDef;
      FrameBattle1.ttCharArmor.Caption := 'Броня: ' + S;
    end;
    //
    if LJSON.TryGetValue('char_equip_weapon_name', S) then
    begin
      pnEqWeapon.Caption := StrLim(S);
      pnEqWeapon.Hint := Format('%s (%s)', [S, LDam]);
    end;
    if LJSON.TryGetValue('char_equip_armor_name', S) then
    begin
      pnEqArmor.Caption := StrLim(S);
      pnEqArmor.Hint := Format('%s (%s)', [S, LDef]);
    end;
    //
    if LJSON.TryGetValue('char_bank', S) then
      FormMain.FrameTown.FrameBank1.Label1.Caption := 'Золото: ' + S;
    //
    if LJSON.TryGetValue('char_effects', S) then
      ChEffectPanel(S);
    //
    if LJSON.TryGetValue('char_inventory', S) then
      FormMain.FrameTown.FrameChar.RefreshInventory(S);
    //
    if LJSON.TryGetValue('stat_kills', S) then
      FormMain.FrameTown.FrameChar.ttStatKills.Caption :=
        Format('Выиграно битв: %s', [S]);
    if LJSON.TryGetValue('stat_deads', S) then
      FormMain.FrameTown.FrameChar.ttStatDeads.Caption :=
        Format('Поражений: %s', [S]);
    if LJSON.TryGetValue('stat_boss_kills', S) then
      FormMain.FrameTown.FrameChar.ttStatBossKills.Caption :=
        Format('Повержено боссов: %s', [S]);

    FormMain.FrameTown.FrameChar.ttWeapon.Caption := pnEqWeapon.Hint;
    FormMain.FrameTown.FrameChar.ttArmor.Caption := pnEqArmor.Hint;
    //
    S := '';
    if LJSON.TryGetValue('enemy_name', S) then
      FormMain.FrameTown.FrameBattle1.ttEnemyName.Caption := S;
    if LJSON.TryGetValue('enemy_level', V) then
      FormMain.FrameTown.FrameBattle1.ttEnemyLevel.Caption := 'Уровень: ' + V;
    if LJSON.TryGetValue('enemy_life_cur', Cur) and
      LJSON.TryGetValue('enemy_life_max', Max) then
    begin
      FormMain.FrameTown.FrameBattle1.ttEnemyLife.Caption :=
        Format('Здоровье: %s/%s', [Cur, Max]);
      ChEnemyLifePanels(Cur, Max);
    end;
    if LJSON.TryGetValue('enemy_damage_min', Cur) and
      LJSON.TryGetValue('enemy_damage_max', Max) then
      FormMain.FrameTown.FrameBattle1.ttEnemyDamage.Caption :=
        Format('Урон: %s-%s', [Cur, Max]);
    if LJSON.TryGetValue('enemy_armor', V) then
      FormMain.FrameTown.FrameBattle1.ttEnemyArmor.Caption := 'Броня: ' + V;
    if LJSON.TryGetValue('enemy_image', S) then
      if ((S <> '') and FileExists(FormInfo.ImagesPath.Caption + S + '.jpg'))
      then
        FormMain.FrameTown.FrameBattle1.Image2.Picture.LoadFromFile
          (FormInfo.ImagesPath.Caption + S + '.jpg');
    LastCode := Code;
    FormMain.Refresh;
  finally
    LJSON.Free;
  end;
end;

end.
