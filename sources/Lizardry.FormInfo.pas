unit Lizardry.FormInfo;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants, System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.ComCtrls;

type
  TFormInfo = class(TForm)
    RichEdit1: TRichEdit;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormInfo: TFormInfo;

procedure MsgBox(const S: string);

implementation

{$R *.dfm}

procedure MsgBox(const S: string);
begin
  FormInfo.RichEdit1.Clear;
  FormInfo.RichEdit1.Lines.Append(S);
end;

end.
