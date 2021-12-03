unit Lizardry.FormInfo;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes, Vcl.Graphics,
  Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.StdCtrls, Vcl.ComCtrls,
  Vcl.ExtCtrls;

type
  TFormInfo = class(TForm)
    PageControl1: TPageControl;
    TabSheet1: TTabSheet;
    RichEdit1: TRichEdit;
    TabSheet2: TTabSheet;
    RichEdit2: TRichEdit;
    TabSheet3: TTabSheet;
    MemoMobImages: TMemo;
    MobImagesPath: TPanel;
    TabSheet4: TTabSheet;
    ErrorMemo: TMemo;
    TabSheet5: TTabSheet;
    InvMemo: TMemo;
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  FormInfo: TFormInfo;

procedure MsgBox(const S: string);
procedure InvError(const S: string);
procedure ShowError(const S: string);

implementation

{$R *.dfm}

procedure MsgBox(const S: string);
begin
  FormInfo.RichEdit1.Clear;
  FormInfo.RichEdit1.Lines.Append(S);
end;

procedure ShowError(const S: string);
begin
  FormInfo.ErrorMemo.Clear;
  FormInfo.ErrorMemo.Lines.Append(S);
end;

procedure InvError(const S: string);
begin
  FormInfo.InvMemo.Clear;
  FormInfo.InvMemo.Lines.Append(S);
end;

end.
