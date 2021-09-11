unit Lizardry.FrameBattle;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.Imaging.jpeg,
  Vcl.ExtCtrls, Vcl.StdCtrls;

type
  TFrameBattle = class(TFrame)
    Image2: TImage;
    Label1: TLabel;
    Label2: TLabel;
    StaticText1: TStaticText;
    Label3: TLabel;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

end.
