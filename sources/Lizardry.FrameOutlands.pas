unit Lizardry.FrameOutlands;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Vcl.Imaging.jpeg, Vcl.ExtCtrls;

type
  TFrameOutlands = class(TFrame)
    Image1: TImage;
    Image2: TImage;
    Image3: TImage;
    Image4: TImage;
    procedure Image1Click(Sender: TObject);
    procedure Image2Click(Sender: TObject);
    procedure Image3Click(Sender: TObject);
    procedure Image4Click(Sender: TObject);
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
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=camp'));
end;

procedure TFrameOutlands.Image2Click(Sender: TObject);
begin
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=battle&enemyslot=1'));
end;

procedure TFrameOutlands.Image3Click(Sender: TObject);
begin
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=battle&enemyslot=2'));
end;

procedure TFrameOutlands.Image4Click(Sender: TObject);
begin
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=battle&enemyslot=3'));
end;

end.
