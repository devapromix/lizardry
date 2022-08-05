unit Lizardry.FrameOutlands;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Vcl.Imaging.jpeg, Vcl.ExtCtrls, Vcl.Imaging.pngimage, Vcl.StdCtrls;

type
  TFrameOutlands = class(TFrame)
    Image1: TImage;
    Image2: TImage;
    Image3: TImage;
    Image4: TImage;
    Label1: TLabel;
    procedure Image1Click(Sender: TObject);
    procedure Image2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server;

procedure TFrameOutlands.Image1Click(Sender: TObject);
begin
  if IsChatMode or IsCharMode then
    Exit;
  FormMain.FrameTown.ParseJSON(Server.Get('index.php?action=campfire'));
end;

procedure TFrameOutlands.Image2Click(Sender: TObject);
begin
  if IsChatMode or IsCharMode then
    Exit;
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=battle&enemyslot=' + IntToStr((Sender as TImage).Tag)));
end;

end.
