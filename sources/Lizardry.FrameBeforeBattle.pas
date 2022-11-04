﻿unit Lizardry.FrameBeforeBattle;

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
  Vcl.Grids,
  Vcl.Imaging.jpeg,
  Vcl.ExtCtrls,
  Vcl.Imaging.pngimage;

type
  TFrameBeforeBattle = class(TFrame)
    Image1: TImage;
    Image2: TImage;
    Image3: TImage;
    procedure Image1Click(Sender: TObject);
    procedure Image3Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses
  Lizardry.FormMain,
  Lizardry.FormPrompt,
  Lizardry.Server,
  Lizardry.Frame.Location.Town;

{ TFrameBeforeBattle }

procedure TFrameBeforeBattle.Image1Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=' + CurrentOutlands));
  end;
end;

procedure TFrameBeforeBattle.Image3Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=battle&do=auto_battle'));
  end;
end;

end.
