﻿unit Lizardry.FrameBank;

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
  Vcl.ComCtrls,
  Vcl.Imaging.PNGImage,
  Vcl.ExtCtrls;

type
  TFrameBank = class(TFrame)
    GoldEdit: TEdit;
    bbDeposit: TBitBtn;
    bbWithdraw: TBitBtn;
    Label1: TLabel;
    UpDown1: TUpDown;
    SpeedButton1: TSpeedButton;
    SpeedButton2: TSpeedButton;
    SpeedButton3: TSpeedButton;
    SpeedButton4: TSpeedButton;
    SpeedButton5: TSpeedButton;
    SpeedButton6: TSpeedButton;
    bbMyGold: TSpeedButton;
    SpeedButton7: TSpeedButton;
    Image2: TImage;
    Image1: TImage;
    procedure bbDepositClick(Sender: TObject);
    procedure bbWithdrawClick(Sender: TObject);
    procedure GoldEditKeyPress(Sender: TObject; var Key: Char);
    procedure SpeedButton1Click(Sender: TObject);
    procedure SpeedButton3Click(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
    procedure SpeedButton4Click(Sender: TObject);
    procedure SpeedButton6Click(Sender: TObject);
    procedure bbMyGoldClick(Sender: TObject);
    procedure SpeedButton7Click(Sender: TObject);
    procedure Image2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
    procedure Modify(const Value: Integer);
  end;

implementation

{$R *.dfm}

uses
  Lizardry.Server,
  Lizardry.FormMain;


procedure TFrameBank.bbDepositClick(Sender: TObject);
var
  Sum: Integer;
begin
  if IsCharMode then
    Exit;
  Sum := StrToIntDef(GoldEdit.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=deposit&amount=' + Sum.ToString));
  GoldEdit.Text := '0';
end;

procedure TFrameBank.bbMyGoldClick(Sender: TObject);
begin
  if IsCharMode then
    Exit;
  GoldEdit.Text := bbMyGold.Caption;
end;

procedure TFrameBank.bbWithdrawClick(Sender: TObject);
var
  Sum: Integer;
begin
  if IsCharMode then
    Exit;
  Sum := StrToIntDef(GoldEdit.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=withdraw&amount=' + Sum.ToString));
  GoldEdit.Text := '0';
end;

procedure TFrameBank.GoldEditKeyPress(Sender: TObject; var Key: Char);
begin
  if IsCharMode then
    Exit;
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['0' .. '9']) then
      Key := #0;
end;

procedure TFrameBank.Image2Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=town'));
  end;
end;

procedure TFrameBank.Modify(const Value: Integer);
var
  N: Integer;
begin
  if IsCharMode then
    Exit;
  N := StrToIntDef(GoldEdit.Text, 0);
  if (N + Value) < 0 then
    Exit;
  N := N + Value;
  GoldEdit.Text := IntToStr(N);
end;

procedure TFrameBank.SpeedButton1Click(Sender: TObject);
begin
  Modify(10);
end;

procedure TFrameBank.SpeedButton2Click(Sender: TObject);
begin
  Modify(-10);
end;

procedure TFrameBank.SpeedButton3Click(Sender: TObject);
begin
  Modify(100);
end;

procedure TFrameBank.SpeedButton4Click(Sender: TObject);
begin
  Modify(-100);
end;

procedure TFrameBank.SpeedButton5Click(Sender: TObject);
begin
  Modify(1000);
end;

procedure TFrameBank.SpeedButton6Click(Sender: TObject);
begin
  Modify(-1000);
end;

procedure TFrameBank.SpeedButton7Click(Sender: TObject);
begin
  if IsCharMode then
    Exit;
  GoldEdit.Text := '0';
end;

end.
