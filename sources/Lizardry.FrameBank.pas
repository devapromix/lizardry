unit Lizardry.FrameBank;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons;

type
  TFrameBank = class(TFrame)
    Edit1: TEdit;
    bbDeposit: TBitBtn;
    bbWithdraw: TBitBtn;
    Label1: TLabel;
    procedure bbDepositClick(Sender: TObject);
    procedure bbWithdrawClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.Server, Lizardry.FormMain;

procedure TFrameBank.bbDepositClick(Sender: TObject);
var
  Sum: Integer;
begin
  Sum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=deposit&amount=' + Sum.ToString));
  Edit1.Text := '0';
end;

procedure TFrameBank.bbWithdrawClick(Sender: TObject);
var
  Sum: Integer;
begin
  Sum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=withdraw&amount=' + Sum.ToString));
  Edit1.Text := '0';
end;

end.
