unit Unit1;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics, Math,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls;

type
  TForm1 = class(TForm)
    Edit1: TEdit;
    Label1: TLabel;
    Memo1: TMemo;
    Button1: TButton;
    Button2: TButton;
    Button3: TButton;
    Edit2: TEdit;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure Button3Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.dfm}

procedure TForm1.Button1Click(Sender: TObject);
var
  I, L, P, H: Integer;
begin
  L := StrToInt(Edit1.Text);
  Memo1.Clear;
  P := 350;
  H := 200;
  for I := 1 to L do
  begin
    Memo1.Lines.Append(Format('Уровень: %d. Цена: %d', [I, P]));
    Inc(P, H);
    if Odd(I) then
      Inc(H, 50);
  end;
end;

procedure TForm1.Button2Click(Sender: TObject);
var
  I, L, P, H: Integer;
begin
  L := StrToInt(Edit1.Text);
  Memo1.Clear;
  P := 220;
  H := 180;
  for I := 1 to L do
  begin
    Memo1.Lines.Append(Format('Уровень: %d. Цена: %d', [I, P]));
    Inc(P, H);
    if Odd(I) then
      Inc(H, 50);
  end;
end;

procedure TForm1.Button3Click(Sender: TObject);
var
  Level: Integer;
  Exp, MaxExp, CurExp: Integer;
  Count: Integer;
begin
  Exp := 0;
  Level := StrToIntDef(Edit2.Text, 1);
  MaxExp := (Level * ((Level - 1) + 100));
  Count := 0;
  CurExp := 0;
  while (CurExp < MaxExp) do
  begin
    Exp := (Level * 3) + RandomRange(Round(Level * 0.1), Round(Level * 0.3));
    Inc(CurExp, Exp);
    Inc(Count);
  end;
  ShowMessage(IntToStr(Count));
end;

end.
