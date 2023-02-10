unit Lizardry.FrameGetAllLoot;

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
  TFrameGetAllLoot = class(TFrame)
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
  Lizardry.Frame.Location.Town,
  Lizardry.FormLocPrompt;

{ TFrameAfterBattle }

procedure TFrameGetAllLoot.Image1Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    LocPrompt('Вы еще не все осмотрели! Покинуть локацию?');
  end;
end;

procedure TFrameGetAllLoot.Image3Click(Sender: TObject);
begin
  with FormMain.FrameTown do
  begin
    if IsCharMode then
      bbCharNameClick(Sender);
    ParseJSON(Server.Get('index.php?action=pickup_all_loot'));
  end;
end;

end.
