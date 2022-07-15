unit Lizardry.FrameChat;

interface

uses
  Winapi.Windows, Winapi.Messages, System.SysUtils, System.Variants,
  System.Classes,
  Vcl.Graphics, Vcl.Controls, Vcl.Forms, Vcl.Dialogs, Vcl.ExtCtrls,
  Vcl.StdCtrls,
  Vcl.Buttons, Vcl.ComCtrls;

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

uses Lizardry.FormMain, Lizardry.Server;

procedure TFrameChat.edChatMsgKeyDown(Sender: TObject; var Key: Word;
  Shift: TShiftState);
var
  S: string;
begin
  if (Key = VK_RETURN) then
  begin
    S := Trim(edChatMsg.Text);
    if (S <> '') then
    begin
      S := Server.Get('messages/add_message.php?charname=' +
        Trim(FormMain.FrameLogin.edUserName.Text) +
        '&action=add_message&message=' + S);
      // ShowMessage(S);
    end;
    edChatMsg.Text := '';
    FormMain.FrameLogin.LoadFromDBMessages;
  end;
  Key := 0;
end;

end.
