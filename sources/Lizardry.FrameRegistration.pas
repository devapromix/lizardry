unit Lizardry.FrameRegistration;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls, Vcl.Imaging.pngimage, Vcl.CheckLst;

type
  TLabel = class(Vcl.StdCtrls.TLabel)
  private
    FChecked: Boolean;
  published
    property Checked: Boolean read FChecked write FChecked;
    procedure Check;
    procedure UnCheck;
  end;

type
  TFrameRegistration = class(TFrame)
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    edUserName: TEdit;
    edUserPass: TEdit;
    edCharName: TEdit;
    bbRegistration: TBitBtn;
    bbBack: TBitBtn;
    Panel1: TPanel;
    Panel2: TPanel;
    Panel3: TPanel;
    Image1: TImage;
    Panel4: TPanel;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    Image2: TImage;
    Label4: TLabel;
    SpeedButton5: TSpeedButton;
    Label5: TLabel;
    SpeedButton6: TSpeedButton;
    gdMale: TLabel;
    gdFemale: TLabel;
    rcHuman: TLabel;
    rcElf: TLabel;
    rcGnome: TLabel;
    Label6: TLabel;
    SpeedButton7: TSpeedButton;
    wpSword: TLabel;
    wpAxe: TLabel;
    wpSpear: TLabel;
    wpStaff: TLabel;
    rcLizard: TLabel;
    arLinenRobe: TLabel;
    arLeatherArmor: TLabel;
    Label9: TLabel;
    SpeedButton8: TSpeedButton;
    SpeedButton9: TSpeedButton;
    Label10: TLabel;
    hmLeatherHelm: TLabel;
    hmClothCap: TLabel;
    wpBow: TLabel;
    wpDagger: TLabel;
    wpHammer: TLabel;
    StaticText1: TStaticText;
    procedure bbBackClick(Sender: TObject);
    procedure bbRegistrationClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
    procedure InfoClick(Sender: TObject);
    procedure rcHumanClick(Sender: TObject);
    procedure rcElfClick(Sender: TObject);
    procedure rcGnomeClick(Sender: TObject);
    procedure gdMaleClick(Sender: TObject);
    procedure gdFemaleClick(Sender: TObject);
    procedure rcLizardClick(Sender: TObject);
    procedure wpSwordClick(Sender: TObject);
    procedure wpAxeClick(Sender: TObject);
    procedure wpSpearClick(Sender: TObject);
    procedure wpStaffClick(Sender: TObject);
    procedure wpBowClick(Sender: TObject);
    procedure wpDaggerClick(Sender: TObject);
    procedure wpHammerClick(Sender: TObject);
    procedure arLeatherArmorClick(Sender: TObject);
    procedure arLinenRobeClick(Sender: TObject);
    procedure hmLeatherHelmClick(Sender: TObject);
    procedure hmClothCapClick(Sender: TObject);
  private
    { Private declarations }
    procedure ClearRaces;
    procedure ClearGenders;
    procedure ClearWeapons;
    procedure ClearArmors;
    procedure ClearHelms;
    procedure LoadImage(S: string);
    procedure LoadImages;
  public
    { Public declarations }
    procedure Clear;
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server, Lizardry.FormMsg, Lizardry.FormInfo,
  System.IOUtils;

procedure TFrameRegistration.arLeatherArmorClick(Sender: TObject);
begin
  ClearArmors;
  arLeatherArmor.Check;
end;

procedure TFrameRegistration.arLinenRobeClick(Sender: TObject);
begin
  ClearArmors;
  arLinenRobe.Check;
end;

procedure TFrameRegistration.bbBackClick(Sender: TObject);
begin
  FormMain.FrameLogin.LoadLastEvents;
  FormMain.FrameLogin.BringToFront;
end;

procedure TFrameRegistration.bbRegistrationClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass, CharName, CharGender, CharRace: string;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  CharName := Trim(edCharName.Text);
  CharGender := '0';
  if gdFemale.Checked then
    CharGender := '1';
  CharRace := '0';
  if rcElf.Checked then
    CharRace := '1';
  if rcGnome.Checked then
    CharRace := '2';
  if rcLizard.Checked then
    CharRace := '3';
  if not TServer.IsInternetConnected then
  begin
    ShowMsg('Невозможно подключиться к серверу!');
    Exit;
  end;
  FormMain.FrameLogin.edUserName.Text := UserName;
  FormMain.FrameLogin.edUserPass.Text := UserPass;
  ResponseCode := Server.Get
    ('registration/registration.php?action=registration&charname=' + CharName +
    '&chargender=' + CharGender + '&charrace=' + CharRace);
  FormMain.FrameLogin.edUserPass.Text := '';
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '1' then
  begin
    ShowMsg('Пользователь с таким именем существует!');
  end
  else if (ResponseCode = '2') then
  begin
    ShowMsg('Регистрация прошла успешно!');
    bbBackClick(Sender);
  end
  else if (ResponseCode = '23') then
  begin
    ShowMsg('Введите имя персонажа!');
  end
  else if (ResponseCode = '33') then
  begin
    ShowMsg('Имя персонажа не должно быть короче 4 символов!');
  end
  else if (ResponseCode = '43') then
  begin
    ShowMsg('Имя персонажа не должно быть длиннее 24 символов!');
  end
  else
  begin
    ShowMsg('Ошибка регистрации!');
    ShowMsg('Код ошибки: ' + ResponseCode);
  end;
end;

procedure TFrameRegistration.hmClothCapClick(Sender: TObject);
begin
  ClearHelms;
  hmClothCap.Check;
end;

procedure TFrameRegistration.hmLeatherHelmClick(Sender: TObject);
begin
  ClearHelms;
  hmLeatherHelm.Check;
end;

procedure TFrameRegistration.Clear;
begin
  edUserName.Text := '';
  edUserPass.Text := '';
  edCharName.Text := '';
  ClearGenders;
  gdMale.Check;
  ClearRaces;
  rcHuman.Check;
  LoadImages;
  StaticText1.Caption := FormMain.FrameTown.GetRaceDescription(0);
  ClearWeapons;
  wpSword.Check;
  ClearArmors;
  arLeatherArmor.Check;
  ClearHelms;
  hmLeatherHelm.Check;
end;

procedure TFrameRegistration.ClearArmors;
begin
  arLeatherArmor.UnCheck;
  arLinenRobe.UnCheck;
end;

procedure TFrameRegistration.ClearGenders;
begin
  gdMale.UnCheck;
  gdFemale.UnCheck;
end;

procedure TFrameRegistration.ClearHelms;
begin
  hmLeatherHelm.UnCheck;
  hmClothCap.UnCheck;
end;

procedure TFrameRegistration.ClearRaces;
begin
  rcHuman.UnCheck;
  rcElf.UnCheck;
  rcGnome.UnCheck;
  rcLizard.UnCheck;
end;

procedure TFrameRegistration.ClearWeapons;
begin
  wpSword.UnCheck;
  wpAxe.UnCheck;
  wpSpear.UnCheck;
  wpStaff.UnCheck;
  wpBow.UnCheck;
  wpDagger.UnCheck;
  wpHammer.UnCheck;
end;

procedure TFrameRegistration.EnterKeyPress(Sender: TObject; var Key: Char);
begin
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['a' .. 'z', 'A' .. 'Z', '0' .. '9', '_']) then
      Key := #0;
  if Key = #13 then
    bbRegistration.Click;
end;

procedure TFrameRegistration.gdFemaleClick(Sender: TObject);
begin
  ClearGenders;
  gdFemale.Check;
  LoadImages;
end;

procedure TFrameRegistration.gdMaleClick(Sender: TObject);
begin
  ClearGenders;
  gdMale.Check;
  LoadImages;
end;

procedure TFrameRegistration.InfoClick(Sender: TObject);
var
  S: string;
begin
  case (Sender as TSpeedButton).Tag of
    1:
      S := 'Название учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, ' +
        'цифры и символ подчеркивания. ' + #13#10 +
        'Длина названия учетной записи: от 4-х до 24-х символов.';
    2:
      S := 'Пароль к учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры ' +
        'и символ подчеркивания. ' + #13#10 +
        'Длина названия учетной записи: от 4-х до 24-х символов.';
    3:
      S := 'Имя персонажа. Придумайте красивое имя для вашего героя. ' + #13#10
        + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';

    4:
      S := 'Нажмите чтобы зарегистрировать свою учетную запись на сервере.';
    5:
      S := 'Выбор расы будущего персонажа. Пока ни на что не ' +
        'влияет кроме изображения персонажа.';
    6:
      S := 'Выбор пола будущего персонажа. Мужской персонаж более силен. ' +
        'Женский персонаж более ловок.';
    7:
      S := 'Выбор оружия персонажа. Добавляет дополнительную силу атаки.';
    8:
      S := 'Выбор брони персонажа. Добавляет дополнительную защиту.';
  else
    S := 'Выбор головного убора. Добавляет дополнительную защиту.';
  end;
  ShowMsg(S);
end;

procedure TFrameRegistration.LoadImage(S: string);
var
  F: string;
begin
  S := 'player_' + LowerCase(S);
  if gdMale.Checked then
    S := S + '_male';
  if gdFemale.Checked then
    S := S + '_female';
  F := TPath.GetHomePath + '\Lizardry\Images\' + S + '.jpg';
  if FileExists(F) then
    Image2.Picture.LoadFromFile(F);
end;

procedure TFrameRegistration.LoadImages;
begin
  if rcHuman.Checked then
    LoadImage('Human');
  if rcElf.Checked then
    LoadImage('Elf');
  if rcGnome.Checked then
    LoadImage('Gnome');
  if rcLizard.Checked then
    LoadImage('Lizard');
end;

procedure TFrameRegistration.rcElfClick(Sender: TObject);
begin
  ClearRaces;
  rcElf.Check;
  LoadImages;
  StaticText1.Caption := FormMain.FrameTown.GetRaceDescription(1);
end;

procedure TFrameRegistration.rcGnomeClick(Sender: TObject);
begin
  ClearRaces;
  rcGnome.Check;
  LoadImages;
  StaticText1.Caption := FormMain.FrameTown.GetRaceDescription(2);
end;

procedure TFrameRegistration.rcHumanClick(Sender: TObject);
begin
  ClearRaces;
  rcHuman.Check;
  LoadImages;
  StaticText1.Caption := FormMain.FrameTown.GetRaceDescription(0);
end;

procedure TFrameRegistration.rcLizardClick(Sender: TObject);
begin
  ClearRaces;
  rcLizard.Check;
  LoadImages;
  StaticText1.Caption := FormMain.FrameTown.GetRaceDescription(3);
end;

procedure TFrameRegistration.wpAxeClick(Sender: TObject);
begin
  ClearWeapons;
  wpAxe.Check;
end;

procedure TFrameRegistration.wpBowClick(Sender: TObject);
begin
  ClearWeapons;
  wpBow.Check;
end;

procedure TFrameRegistration.wpDaggerClick(Sender: TObject);
begin
  ClearWeapons;
  wpDagger.Check;
end;

procedure TFrameRegistration.wpHammerClick(Sender: TObject);
begin
  ClearWeapons;
  wpHammer.Check;
end;

procedure TFrameRegistration.wpSpearClick(Sender: TObject);
begin
  ClearWeapons;
  wpSpear.Check;
end;

procedure TFrameRegistration.wpStaffClick(Sender: TObject);
begin
  ClearWeapons;
  wpStaff.Check;
end;

procedure TFrameRegistration.wpSwordClick(Sender: TObject);
begin
  ClearWeapons;
  wpSword.Check;
end;

{ TLabel }

procedure TLabel.Check;
begin
  Self.Caption := '> ' + Trim(Self.Caption);
  Self.Font.Style := [fsBold];
  FChecked := True;
end;

procedure TLabel.UnCheck;
begin
  Self.Caption := StringReplace(Self.Caption, '>', ' ', [rfReplaceAll]);
  Self.Caption := '  ' + Trim(Self.Caption);
  Self.Font.Style := [];
  FChecked := False;
end;

end.
