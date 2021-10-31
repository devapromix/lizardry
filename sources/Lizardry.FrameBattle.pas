unit Lizardry.FrameBattle;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs,
  Vcl.Imaging.jpeg, Vcl.ExtCtrls, Vcl.StdCtrls, Vcl.ComCtrls;

type
  TFrameBattle = class(TFrame)
    Panel1: TPanel;
    Panel2: TPanel;
    ttEnemyDamage: TLabel;
    ttEnemyLife: TLabel;
    ttEnemyName: TLabel;
    Image2: TImage;
    Panel3: TPanel;
    Image1: TImage;
    Label4: TLabel;
    Label5: TLabel;
    ttCharDamage: TLabel;
    Label7: TLabel;
    ttEnemyLevel: TLabel;
    BattleLog: TRichEdit;
    ttEnemyArmor: TLabel;
    ttCharArmor: TLabel;
  private
    { Private declarations }
  public
    { Public declarations }
    procedure DrawBattleLog(S: string);
  end;

implementation

{$R *.dfm}
{ TFrameBattle }

procedure TFrameBattle.DrawBattleLog(S: string);
begin
  BattleLog.Text := S.Replace('#', #13#10);
  SendMessage(BattleLog.Handle, WM_VSCROLL, SB_BOTTOM, 0);
end;

end.
