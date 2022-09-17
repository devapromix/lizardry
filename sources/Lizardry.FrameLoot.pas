﻿unit Lizardry.FrameLoot;

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
  TFrameLoot = class(TFrame)
    Image1: TImage;
    Image2: TImage;
    procedure Image1Click(Sender: TObject);
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

{ TFrameLoot }

procedure TFrameLoot.Image1Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsChatMode then
      bbChatClick(Sender);
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=' + CurrentOutlands));
  end;
end;

end.
