unit Unit1;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls;

type
  TForm1 = class(TForm)
    Edit1: TEdit;
    Edit2: TEdit;
    Button1: TButton;
    Label1: TLabel;
    Label2: TLabel;
    Label3: TLabel;
    Label4: TLabel;
    Label5: TLabel;
    Label6: TLabel;
    Label7: TLabel;
    Label8: TLabel;
    Edit3: TEdit;
    Edit4: TEdit;
    procedure Button1Click(Sender: TObject);
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
  CharLevel, EnemyLevel: Integer;
  CharClass, EnemyClass: Integer;
  CharHP, EnemyHP: Integer;
  CharDamage, EnemyDamage: Integer;
  CharArmor, EnemyArmor: Integer;
  CharTurns, EnemyTurns: Integer;
begin
  CharLevel := StrToIntDef(Edit1.Text, 1);
  EnemyLevel := StrToIntDef(Edit2.Text, 1);

  CharClass := StrToIntDef(Edit3.Text, 1);
  EnemyClass := StrToIntDef(Edit4.Text, 1);

  CharHP := 25 + (CharLevel * (CharClass + 4));
  EnemyHP := 25 + (EnemyLevel * (EnemyClass + 4));

  CharDamage := Round(CharLevel * 0.5) + 2;
  EnemyDamage := Round(EnemyLevel * 0.5) + 2;

  CharArmor := Round((CharLevel * 0.5) + 0.5);
  EnemyArmor := Round((EnemyLevel * 0.5) + 0.5);

  CharTurns := Round(CharHP / CharDamage);
  EnemyTurns := Round(EnemyHP / EnemyDamage);

  Label1.Caption := Format('HP: %d', [CharHP]);
  Label2.Caption := Format('HP: %d', [EnemyHP]);
  Label3.Caption := Format('Damage: %d-%d', [CharDamage - 2, CharDamage]);
  Label4.Caption := Format('Damage: %d-%d', [EnemyDamage - 2, EnemyDamage]);
  Label5.Caption := Format('Armor: %d', [CharArmor]);
  Label6.Caption := Format('Armor: %d', [EnemyArmor]);
  Label7.Caption := Format('Turns: %d', [CharTurns]);
  Label8.Caption := Format('Turns: %d', [EnemyTurns]);
end;

end.
