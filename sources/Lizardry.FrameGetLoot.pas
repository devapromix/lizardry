unit Lizardry.FrameGetLoot;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Grids,
  Vcl.Imaging.jpeg, Vcl.ExtCtrls, Vcl.Imaging.pngimage;

type
  TFrameGetLoot = class(TFrame)
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

{ TFrameAfterBattle }

procedure TFrameGetLoot.Image1Click(Sender: TObject);
begin
  if IsChatMode or IsCharMode then
    Exit;
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=' + CurrentOutlands));
end;

procedure TFrameGetLoot.Image3Click(Sender: TObject);
begin
  if IsChatMode or IsCharMode then
    Exit;
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=pickup_loot&lootslot=1'));
end;

end.
