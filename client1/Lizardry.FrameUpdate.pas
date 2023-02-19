unit Lizardry.FrameUpdate;

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
  Vcl.Imaging.PNGImage;

type
  TFrameUpdate = class(TFrame)
    Panel1: TPanel;
    bbBack: TBitBtn;
    Panel3: TPanel;
    Image1: TImage;
    Panel2: TPanel;
    bbDownloads: TBitBtn;
    SpeedButton5: TSpeedButton;
    ttInfo: TLabel;
    bbUpdImages: TBitBtn;
    ttUpdate: TLabel;
    SpeedButton1: TSpeedButton;
    bbIssues: TBitBtn;
    bbQA: TBitBtn;
    SpeedButton2: TSpeedButton;
    procedure bbBackClick(Sender: TObject);
    procedure bbDownloadsClick(Sender: TObject);
    procedure SpeedButton5Click(Sender: TObject);
    procedure bbUpdImagesClick(Sender: TObject);
    procedure SpeedButton1Click(Sender: TObject);
    procedure bbIssuesClick(Sender: TObject);
    procedure bbQAClick(Sender: TObject);
    procedure SpeedButton2Click(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

implementation

{$R *.dfm}

uses
  ShellAPI,
  Lizardry.FormMain,
  Lizardry.FormMsg;

procedure TFrameUpdate.bbBackClick(Sender: TObject);
begin
  FormMain.FrameLogin.LoadLastEvents;
  FormMain.FrameLogin.BringToFront;
end;

procedure TFrameUpdate.bbIssuesClick(Sender: TObject);
begin
  ShellExecute(handle, 'open', 'https://github.com/devapromix/lizardry/issues',
    nil, nil, SW_SHOW);
end;

procedure TFrameUpdate.bbQAClick(Sender: TObject);
begin
  ShellExecute(handle, 'open',
    'https://github.com/devapromix/lizardry/discussions/categories/q-a', nil,
    nil, SW_SHOW);
end;

procedure TFrameUpdate.bbDownloadsClick(Sender: TObject);
begin
  ShellExecute(handle, 'open',
    'https://github.com/devapromix/lizardry/releases', nil, nil, SW_SHOW);
end;

procedure TFrameUpdate.bbUpdImagesClick(Sender: TObject);
begin
  FormMain.FrameLogin.LoadFromDBEnemies(True);
end;

procedure TFrameUpdate.SpeedButton1Click(Sender: TObject);
begin
  ShowMsg('Принудительная загрузка и обновление всех изображений.');
end;

procedure TFrameUpdate.SpeedButton2Click(Sender: TObject);
begin
  ShellExecute(handle, 'open',
    'https://github.com/devapromix/lizardry', nil, nil, SW_SHOW);
end;

procedure TFrameUpdate.SpeedButton5Click(Sender: TObject);
begin
  ShowMsg('Открыть на Github страницу загрузки самой новой версии клиента.');
end;

end.
