unit Unit1;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls;

type
  TForm1 = class(TForm)
    Edit1: TEdit;
    Label1: TLabel;
    Memo1: TMemo;
    Button1: TButton;
    Button2: TButton;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
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

end.
