unit Lizardry.FrameChar;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.ComCtrls;

type
  TFrameChar = class(TFrame)
    ttStatKills: TLabel;
    PageControl1: TPageControl;
    TabSheet1: TTabSheet;
    TabSheet2: TTabSheet;
    TabSheet3: TTabSheet;
    ttStatDeads: TLabel;
    ttWeapon: TLabel;
    ttArmor: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    TabSheet4: TTabSheet;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

end.
