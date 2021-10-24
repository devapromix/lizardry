unit Lizardry.FrameBank;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.Buttons,
  Vcl.ComCtrls;

type
  TFrameBank = class(TFrame)
    Edit1: TEdit;
    bbDeposit: TBitBtn;
    bbWithdraw: TBitBtn;
    Label1: TLabel;
    UpDown1: TUpDown;
    procedure bbDepositClick(Sender: TObject);
    procedure bbWithdrawClick(Sender: TObject);
    procedure Edit1KeyPress(Sender: TObject; var Key: Char);
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
  if IsChatMode or IsCharMode then
    Exit;
  Sum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=deposit&amount=' + Sum.ToString));
  Edit1.Text := '0';
end;

procedure TFrameBank.bbWithdrawClick(Sender: TObject);
var
  Sum: Integer;
begin
  if IsChatMode or IsCharMode then
    Exit;
  Sum := StrToIntDef(Edit1.Text, 0);
  FormMain.FrameTown.ParseJSON
    (Server.Get('index.php?action=bank&do=withdraw&amount=' + Sum.ToString));
  Edit1.Text := '0';
end;

procedure TFrameBank.Edit1KeyPress(Sender: TObject; var Key: Char);
begin
  if IsChatMode or IsCharMode then
    Exit;
  if (ord(Key) >= 32) then
    if not(Char(Key) in ['0' .. '9']) then
      Key := #0;
end;

end.
