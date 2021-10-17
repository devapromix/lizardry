unit Lizardry.FrameShop;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls;

type
  TFrameShop = class(TFrame)
    Panel12: TPanel;
    Panel1: TPanel;
    pnShopItemValueName: TPanel;
    Panel3: TPanel;
    Panel4: TPanel;
    pnItemSlot5Name: TPanel;
    pnItemSlot5Value: TPanel;
    pnItemSlot5Price: TPanel;
    Panel8: TPanel;
    pnItemSlot1Name: TPanel;
    pnItemSlot1Value: TPanel;
    pnItemSlot1Price: TPanel;
    Panel2: TPanel;
    pnItemSlot4Name: TPanel;
    pnItemSlot4Value: TPanel;
    pnItemSlot4Price: TPanel;
    Panel16: TPanel;
    pnItemSlot3Name: TPanel;
    pnItemSlot3Value: TPanel;
    pnItemSlot3Price: TPanel;
    Panel20: TPanel;
    pnItemSlot2Name: TPanel;
    pnItemSlot2Value: TPanel;
    pnItemSlot2Price: TPanel;
    Panel5: TPanel;
    lbShopDescr: TLabel;
    Label1: TLabel;
    Panel6: TPanel;
    pnItemSlot1Level: TPanel;
    pnItemSlot2Level: TPanel;
    pnItemSlot3Level: TPanel;
    pnItemSlot4Level: TPanel;
    pnItemSlot5Level: TPanel;
    procedure pnItemSlot1NameClick(Sender: TObject);
    procedure pnItemSlot2NameClick(Sender: TObject);
    procedure pnItemSlot3NameClick(Sender: TObject);
    procedure pnItemSlot4NameClick(Sender: TObject);
    procedure pnItemSlot5NameClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses Lizardry.FormMain, Lizardry.Server, Lizardry.FormPrompt;

const
  Msg = 'Купить %s за %s золотых?';

procedure TFrameShop.pnItemSlot1NameClick(Sender: TObject);
begin
  if IsChatMode then
    Exit;
  Prompt(Format(Msg, [pnItemSlot1Name.Caption, pnItemSlot1Price.Caption]),
    'Купить', 'index.php?action=shop_armor&do=buy&itemslot=1');
end;

procedure TFrameShop.pnItemSlot2NameClick(Sender: TObject);
begin
  if IsChatMode then
    Exit;
  Prompt(Format(Msg, [pnItemSlot2Name.Caption, pnItemSlot2Price.Caption]),
    'Купить', 'index.php?action=shop_armor&do=buy&itemslot=2');
end;

procedure TFrameShop.pnItemSlot3NameClick(Sender: TObject);
begin
  if IsChatMode then
    Exit;
  Prompt(Format(Msg, [pnItemSlot3Name.Caption, pnItemSlot3Price.Caption]),
    'Купить', 'index.php?action=shop_armor&do=buy&itemslot=3');
end;

procedure TFrameShop.pnItemSlot4NameClick(Sender: TObject);
begin
  if IsChatMode then
    Exit;
  Prompt(Format(Msg, [pnItemSlot4Name.Caption, pnItemSlot4Price.Caption]),
    'Купить', 'index.php?action=shop_armor&do=buy&itemslot=4');
end;

procedure TFrameShop.pnItemSlot5NameClick(Sender: TObject);
begin
  if IsChatMode then
    Exit;
  Prompt(Format(Msg, [pnItemSlot5Name.Caption, pnItemSlot5Price.Caption]),
    'Купить', 'index.php?action=shop_armor&do=buy&itemslot=5');
end;

end.
