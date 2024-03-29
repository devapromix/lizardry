﻿unit Lizardry.FormMain;

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
  Lizardry.FrameLogin,
  Lizardry.FrameRegistration,
  Lizardry.Frame.Location.Town,
  IdAntiFreezeBase,
  IdAntiFreeze,
  IdBaseComponent,
  IdComponent,
  IdTCPConnection,
  IdTCPClient,
  IdHTTP,
  Lizardry.FrameUpdate,
  Vcl.ComCtrls;

type
  TFormMain = class(TForm)
    FrameLogin: TFrameLogin;
    FrameRegistration: TFrameRegistration;
    FrameTown: TFrameTown;
    FrameUpdate: TFrameUpdate;
    StatusBar: TStatusBar;
    procedure FormCreate(Sender: TObject);
    procedure FormShow(Sender: TObject);
    procedure FrameUpdatebbOpenSiteClick(Sender: TObject);
    procedure FormResize(Sender: TObject);
  private
    { Private declarations }
    function GameName: string;
  public
    { Public declarations }
    procedure UpdateCaption;
  end;

var
  FormMain: TFormMain;
  IsCharMode: Boolean = False;
  IsDebugMode: Boolean = False;
  ServerName: string = '';

implementation

{$R *.dfm}

uses
  Registry,
  Lizardry.FormInfo,
  Lizardry.FormMsg,
  Lizardry.Server;

procedure TFormMain.FormCreate(Sender: TObject);
var
  LParam: Integer;
begin
  for LParam := 1 to ParamCount do
    if ParamStr(LParam) = '-debug' then
      IsDebugMode := True;
  FrameLogin.bbDebug.Visible := IsDebugMode;
  FrameLogin.BringToFront;
  StatusBar.Visible := IsDebugMode;
end;

procedure TFormMain.FormResize(Sender: TObject);
begin
  FormMain.FrameTown.FrameShop1.DrawGrid;
  FormMain.FrameTown.FrameChar.DrawGrid;
end;

procedure TFormMain.FormShow(Sender: TObject);
var
  LRegistry: TRegistry;
begin
  LRegistry := TRegistry.Create;
  try
    LRegistry.RootKey := HKEY_CURRENT_USER;
    LRegistry.OpenKey('\SOFTWARE\Lizardry', True);
    FrameLogin.edUserName.SetFocus;
    if LRegistry.ValueExists('UserName') then
    begin
      FrameLogin.edUserName.Text := LRegistry.ReadString('UserName');
      if LRegistry.ValueExists('UserPass') then
        FrameLogin.edUserPass.Text := LRegistry.ReadString('UserPass');
      FrameLogin.edUserPass.SetFocus;
    end;
    if LRegistry.ValueExists('Server') then
      FrameLogin.ComboBox1.ItemIndex := LRegistry.ReadInteger('Server')
    else
      FrameLogin.ComboBox1.ItemIndex := 0;
    FrameLogin.ComboBox1Change(Sender);
  finally
    LRegistry.Free;
  end;
end;

procedure TFormMain.FrameUpdatebbOpenSiteClick(Sender: TObject);
begin
  FrameUpdate.bbDownloadsClick(Sender);
end;

function TFormMain.GameName: string;
begin
  Result := 'LIZARDRY';
  if IsDebugMode then
    Result := 'LIZARDRY [DEBUG]';
end;

procedure TFormMain.UpdateCaption;
begin
  if ServerName = '' then
    Self.Caption := GameName
  else
    Self.Caption := Format(Trim('%s [%s]'), [GameName, UpperCase(ServerName)]);
end;

end.
