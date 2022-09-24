unit Lizardry.FrameChat;

interface

uses
  Winapi.Windows,
  Winapi.Messages,
  System.SysUtils,
  System.Variants,
  System.Classes,
  Vcl.Graphics,
  Vcl.Controls,
  Vcl.Forms,
  Vcl.Dialogs,
  Vcl.ExtCtrls,
  Vcl.StdCtrls,
  Vcl.Buttons,
  Vcl.ComCtrls;

type
  TFrameChat = class(TFrame)
    Panel1: TPanel;
    Panel2: TPanel;
    edChatMsg: TEdit;
    RichEdit1: TRichEdit;
    procedure edChatMsgKeyDown(Sender: TObject; var Key: Word;
      Shift: TShiftState);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses
  Lizardry.FormMain,
  Lizardry.Server;

procedure TFrameChat.edChatMsgKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var
  LMessage, LResponseJSON: string;
  SL: TStringList;
begin
  if (Key = VK_RETURN) then
  begin
    SL := TStringList.Create;
    LMessage := Trim(edChatMsg.Text);
    try
      if (LMessage <> '') then //
      begin
        LResponseJSON := Server.Post('messages/add_message.php?charname=' +
          LowerCase(FormMain.FrameTown.bbCharName.Caption) +
          '&action=add_message', SL);
        if LResponseJSON = '{"login":"error"}' then;
        // ShowMessage(S);
      end;
      edChatMsg.Text := '';
      FormMain.FrameLogin.LoadFromDBMessages;
    finally
      FreeAndNil(SL);
    end;
  end;
  Key := 0;
end;

end.
