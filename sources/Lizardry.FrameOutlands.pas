unit Lizardry.FrameOutlands;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.Imaging.jpeg,
  Vcl.ExtCtrls;

type
  TFrameOutlands = class(TFrame)
    Image1: TImage;
    Image2: TImage;
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
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=forest&do=rest_in_outlands'));
end;

procedure TFrameOutlands.Image2Click(Sender: TObject);
begin
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=battle'));
end;

end.
