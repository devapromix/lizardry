unit Lizardry.FrameRegistration;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ExtCtrls, Vcl.Imaging.pngimage;

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
    procedure bbBackClick(Sender: TObject);
    procedure bbRegistrationClick(Sender: TObject);
    procedure EnterKeyPress(Sender: TObject; var Key: Char);
    procedure InfoClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure Clear;
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server;

procedure TFrameRegistration.bbBackClick(Sender: TObject);
begin
  FormMain.FrameLogin.BringToFront;
end;

procedure TFrameRegistration.bbRegistrationClick(Sender: TObject);
var
  ResponseCode, UserName, UserPass, CharName: string;
begin
  UserName := Trim(LowerCase(edUserName.Text));
  UserPass := Trim(LowerCase(edUserPass.Text));
  CharName := Trim(edCharName.Text);
  if not TServer.IsInternetConnected then
  begin
    ShowMessage('Невозможно подключиться к серверу!');
    Exit;
  end;
  FormMain.FrameLogin.edUserName.Text := UserName;
  FormMain.FrameLogin.edUserPass.Text := UserPass;
  ResponseCode := Server.Get
    ('registration/registration.php?action=registration&charname=' + CharName);
  FormMain.FrameLogin.edUserPass.Text := '';
  if TServer.CheckLoginErrors(ResponseCode) then
    Exit;
  if ResponseCode = '1' then
  begin
    ShowMessage('Пользователь с таким именем существует!');
  end
  else if (ResponseCode = '2') then
  begin
    ShowMessage('Регистрация прошла успешно!');
    FormMain.FrameLogin.BringToFront;
  end
  else if (ResponseCode = '23') then
  begin
    ShowMessage('Введите имя персонажа!');
  end
  else if (ResponseCode = '33') then
  begin
    ShowMessage('Имя персонажа не должно быть короче 4 символов!');
  end
  else if (ResponseCode = '43') then
  begin
    ShowMessage('Имя персонажа не должно быть длиннее 24 символов!');
  end
  else
  begin
    ShowMessage('Ошибка регистрации!');
    ShowMessage('Код ошибки: ' + ResponseCode);
  end;
end;

procedure TFrameRegistration.Clear;
begin
  edUserName.Text := '';
  edUserPass.Text := '';
  edCharName.Text := '';
end;

procedure TFrameRegistration.EnterKeyPress(Sender: TObject; var Key: Char);
begin
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['a' .. 'z', 'A' .. 'Z', '0' .. '9', '_']) then
      Key := #0;
  if Key = #13 then
    bbRegistration.Click;
end;

procedure TFrameRegistration.InfoClick(Sender: TObject);
var
  S: string;
begin
  case (Sender as TSpeedButton).Tag of
    1:
      S := 'Название учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    2:
      S := 'Пароль к учетной записи. Используется только для входа в игру. ' +
        #13#10 + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';
    3:
      S := 'Имя персонажа. Придумайте красивое имя для вашего героя. ' + #13#10
        + 'Можно использовать символы от aA до zZ, цифры и символ подчеркивания. '
        + #13#10 + 'Длина названия учетной записи: от 4-х до 24-х символов.';

  else
    S := 'Нажмите чтобы зарегистрировать свою учетную запись на сервере.';
  end;
  ShowMessage(S);
end;

end.
